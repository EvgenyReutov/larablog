<?php

namespace Tests\DataGenerators;

use App\Models\Tag;

trait TagGenerator
{
    public function generateTags($count = 10)
    {
        $tags = [];
        for ($i = 0; $i < $count; $i ++) {
            $tags[] = Tag::factory()->create();


        }

        return compact('tags');
    }
}
