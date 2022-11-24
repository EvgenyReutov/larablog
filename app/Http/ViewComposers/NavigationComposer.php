<?php

namespace App\Http\ViewComposers;

use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view)
    {
        $menuItems = (new TagService())->getList();

        return $view->with(['menuitems' => $menuItems]);
    }

}
