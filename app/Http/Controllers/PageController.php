<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;

class PageController extends Controller
{
    public function view($slug)
    {
        return Page::query()->with('scripts', 'styles', 'tabs')
            ->where('url', '=', $slug)->firstOrFail();
    }

    public function show($slug = 'index')
    {
        $menus = Menu::with('menuItems.' . implode('.', array_fill(0, 100, 'nodes')))
            ->get()->keyBy('name')->map(function ($item){
                return $item->menuItems;
            })->toArray();
        /** @var Page $page */
        $page = Page::query()->with('scripts', 'styles', 'tabs')
            ->where('url', '=', $slug)->firstOrFail();
        $response = $page ? view($page->type, compact('page', 'menus')) : redirect('/');
        return $response;
    }
}
