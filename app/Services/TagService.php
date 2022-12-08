<?php

namespace App\Services;


use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class TagService
{
    public function getList(): Collection
    {
        $list = Cache::store('memcached')->tags('tags')
            ->remember(Tag::getCacheKey(), 600, function(){
                return Tag::get();
            });

        return $list;
    }

}
