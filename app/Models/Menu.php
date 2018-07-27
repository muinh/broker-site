<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property $id
 * @property Collection $menu_items
 */
class Menu extends Model
{
    protected $table = 'front_menus';
    public $timestamps = false;

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id')
            ->where('pid', '=', 0);
    }
}
