<?php

namespace Tests\Feature;

use App\Enums\PostStatus;
use App\Models\Tag;
use App\Services\Notification\LogNotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\DataGenerators\TagGenerator;
use Tests\DataGenerators\UserGenerator;
use Tests\TestCase;

/**
 * @group tags
 */
class AdminTagControllerTest extends TestCase
{
    use TagGenerator, UserGenerator, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        //$user = $this->generateUser();

        $admin = $this->generateUser(['email' => 'renext@mail.ru']);
        $this->actingAs($admin);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list()
    {
        $data = $this->generateTags();

        $response = $this->get(route('admin.tags.index'));

        $response->assertStatus(200);

        foreach ($data['tags'] as $tag) {
            $response->assertSeeText($tag->title);
        }
    }

    public function test_cannot_see_if_not_authentificated()
    {
        Auth::logout();

        $response = $this->get(route('admin.tags.index'));

        $response->assertStatus(302);

    }

    public function test_successfull_tag_creation()
    {
        // 1. Arrange
        $data = [
            'title' => 'newtext',
        ];

        // 2. Act
        $response = $this
            ->from(route('admin.tags.create'))
            ->post(route('admin.tags.store'), $data);

        //$response->dd();
        $response->assertValid([
           'title',
       ]);

        $response->assertStatus(302)
            ->assertRedirect(route('admin.tags.create'))
        ;

        $this->assertEquals(1, Tag::count());

        $tag = Tag::first();
        $this->assertEquals($data['title'], $tag->title);

    }

    /**
     *
     * @return void
     */
    public function test_successfull_tag_update()
    {
        // 1. Arrange
        $data = $this->generateTags();
        $tag = array_shift($data['tags']);

        $dataUpdate = [
            'title' => 'new-text2',
        ];

        $response = $this
            ->from(route('admin.tags.edit', ['tag' => $tag->id]))
            ->put(route('admin.tags.update', ['tag' => $tag->id]), $dataUpdate);

        $response->assertValid([
            'title',
       ]);

        $response->assertStatus(302)
            ->assertRedirect(route('admin.tags.edit', ['tag' => $tag->id]))
        ;

        $post = Tag::query()->where('id', '=',  $tag->id)->first();

        $this->assertEquals($dataUpdate['title'], $post->title);

    }

    /**
     * 
     * @return void
     */
    public function test_successfull_tag_delete()
    {
        // 1. Arrange
        $data = $this->generateTags(1);
        $tag = array_shift($data['tags']);

        $response = $this
            ->from(route('admin.tags.edit', ['tag' => $tag->id]))
            ->delete(route('admin.tags.destroy', ['tag' => $tag->id]));

        $response->assertStatus(302)
            ->assertRedirect(route('admin.tags.index'));


        $count = Tag::count();
        $this->assertEquals(0, $count);

    }
}
