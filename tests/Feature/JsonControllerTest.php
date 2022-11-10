<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @group json
 */
class JsonControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/json');

        $response->assertStatus(200)
        //->assertJson(['status' => 'ok'])
        //->assertExactJson(['status' => 'ok'])
        ->assertJsonStructure(
            [
                'status',
                'data' => [
                    'posts' => [
                        '*' => [
                            'id', 'title'
                        ]
                    ]
                ]
            ]

        )
        ;
    }
}
