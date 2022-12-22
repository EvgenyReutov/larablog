<?php

namespace Tests\Feature;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use App\Services\Notification\LogNotificationService;
use App\Services\Notification\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Mockery\Mock;
use Tests\DataGenerators\PostGenerator;
use Tests\DataGenerators\UserGenerator;
use Tests\TestCase;

/**
 * @group posts
 */
class AdminPostControllerTest extends TestCase
{
    use PostGenerator, UserGenerator, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        //$user = $this->generateUser();
        //$admin = User::query()->where('email', '=', 'renext@mail.ru')->first();
        $admin = $this->generateUser(['email' => 'renext@mail.ru']);
        $this->actingAs($admin);
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list()
    {
        $data = $this->generatePosts();

        //Auth::login($user);

        $response = $this->get(route('admin.posts.index'));

        $response->assertStatus(200);

        foreach ($data['posts'] as $post) {
            $response->assertSeeText($post->title);
        }
    }


    public function test_cannot_see_if_not_authentificated()
    {
        Auth::logout();

        $response = $this->get(route('admin.posts.index'));

        $response->assertStatus(302);

    }

    /**
     *
     * @return void
     */
    public function test_successfull_post_creation()
    {
        // 1. Arrange
        $author = $this->generateUser();
        $data = [
            'title' => 'new text',
            'slug' => 'new-slug'.rand(1,1000),
            'text' => 'new text for text',
            'author_id' => $author->id,
            'status' => PostStatus::Active->value,
        ];

        $serviceMock = $this->spy(LogNotificationService::class);
        /*$this->mock(LogNotificationService::class, function ($service) {
            $service->shouldReceive('notify')
                ->andReturn(true)
                ->once()
            ;
        });*/

        // 2. Act
        $response = $this
            ->from(route('admin.posts.create'))
            ->post(route('admin.posts.store'), $data);

        //$response->dd();
       $response->assertValid([
           'title',
           'slug',
           'text',
           'author_id',
           'status',
       ]);


        $response->assertStatus(302)
            ->assertRedirect(route('admin.posts.create'))
        ;

        $post = Post::first();

        $this->assertEquals(1, Post::count());

        $this->assertEquals($data['title'], $post->title);
        $this->assertEquals($data['slug'], $post->slug);
        $this->assertEquals($data['text'], $post->text);
        $this->assertEquals($data['status'], $post->status->value);
        $this->assertEquals($data['author_id'], $post->author_id);

        $serviceMock->shouldHaveReceived('notify')
            ->with(1, "User with id = ".$post->author_id." has created a post with id = ".$post->id)
            ->once()
            ;
    }

    public function test_no_title_post_creation()
    {
        $author = $this->generateUser();
        $data = [
           // 'title' => 'new text',
            'slug' => 'new-slug',
            'text' => 'new text for text',
            'author_id' => $author->id,
            'status' => PostStatus::Active->value,
        ];

        $response = $this
            ->from(route('admin.posts.create'))
            ->post(route('admin.posts.store'), $data);

        //$response->dd();
        $response->assertValid([
           'slug',
           'text',
           'author_id',
           'status',
       ])->assertInvalid(['title' => 'required']);


        $response->assertStatus(302)
            ->assertRedirect(route('admin.posts.create'))
        ;

        $this->assertEquals(0, Post::count());

    }

    public function test_min_text_post_creation()
    {
        $author = $this->generateUser();
        $data = [
            'title' => 'new text',
            'slug' => 'new-slug',
            'text' => 'new text',
            'author_id' => $author->id,
            'status' => PostStatus::Active->value,
        ];

        $response = $this
            ->from(route('admin.posts.create'))
            ->post(route('admin.posts.store'), $data);

        //$response->dd();
        $response->assertValid([
           'slug',
           'title',
           'author_id',
           'status',
       ])->assertInvalid(['text' => "The text must be at least 10 characters."]);


        $response->assertStatus(302)
            ->assertRedirect(route('admin.posts.create'))
        ;

        $this->assertEquals(0, Post::count());

    }

    /**
     *
     * @return void
     */
    public function test_successfull_post_update()
    {
        // 1. Arrange
        $data = $this->generatePosts();
        $post = array_shift($data['posts']);
        /*dd($post->id);
        foreach ($data['posts'] as $post) {
            dd($post->id);
        }*/

        $author = $this->generateUser();

        $dataUpdate = [
            'title' => 'new text2',
            'slug' => 'new-slug2',
            'text' => 'new text for text2',
            'author_id' => $author->id,
            '_method' => 'PUT',
            'status' => PostStatus::Draft->value,
        ];

        $response = $this
            ->from(route('admin.posts.edit', ['post' => $post->id]))
            //->withSession(['foo' => 'bar'])
            //->withHeaders(['Accept' => 'application/json'])
            ->post(route('admin.posts.update', ['post' => $post->id]), $dataUpdate);

        $response->assertValid([
           'title',
           'slug',
           'text',
           'author_id',
           'status',
       ]);

        $response->assertStatus(302)
            ->assertRedirect(route('admin.posts.edit', ['post' => $post->id]))
        ;

        $post = Post::query()->where('id', '=',  $post->id)->first();

        $this->assertEquals($dataUpdate['title'], $post->title);
        $this->assertEquals($dataUpdate['slug'], $post->slug);
        $this->assertEquals($dataUpdate['text'], $post->text);
        $this->assertEquals($dataUpdate['status'], $post->status->value);
        $this->assertEquals($dataUpdate['author_id'], $post->author_id);

    }

    /**
     *
     * @return void
     */
    public function test_successfull_post_delete()
    {
        // 1. Arrange
        $data = $this->generatePosts(1);
        $post = array_shift($data['posts']);

        $response = $this
            ->from(route('admin.posts.edit', ['post' => $post->id]))
            ->delete(route('admin.posts.destroy', ['post' => $post->id]));

        $response->assertStatus(302)
            ->assertRedirect(route('admin.posts.index'));


        $count = Post::count();
        $this->assertEquals(0, $count);

    }

}
