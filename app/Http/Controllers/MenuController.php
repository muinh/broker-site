<?php
namespace App\Http\Controllers;

use App\Models\Menu;

class MenuController extends Controller
{
    public function get($name)
    {
        $menu = Menu::with('menuItems.' . implode('.', array_fill(0, 100, 'nodes')))
            ->where('name', $name)
            ->first();
        return $menu;
    }
}
