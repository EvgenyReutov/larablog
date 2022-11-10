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
        $user = $this->generateUser();
        $this->actingAs($user);
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
    public function test_example()
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

    public function test_successfull_post_creation()
    {
        // 1. Arrange
        $author = $this->generateUser();
        $data = [
            'title' => 'new text',
            'slug' => 'new-slug',
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

        $this->assertEquals(1, Post::count());

        $post = Post::first();
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
}
