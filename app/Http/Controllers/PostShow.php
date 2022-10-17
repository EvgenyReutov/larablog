<?php

namespace App\Http\Controllers;

use App\DTO\PostDTO;
use App\Enums\PostStatus;
use Illuminate\Http\Request;

class PostShow extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $obj = new PostDTO(1, 'a', PostStatus::Active);

        $res = $obj(1, 'two', true, []);

        dump($res);

        return $res;
    }
}
