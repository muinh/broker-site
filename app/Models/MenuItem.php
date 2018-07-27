<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property $id
 * @property $menu_id
 * @property $pid
 * @property $title
 * @property $url
 * @property Collection $nodes
 */
class MenuItem extends Model
{
    public $timestamps = false;
    protected $table = 'front_menu_items';
    protected $hidden = ['menu_id', 'pid'];
    public function nodes() {
        return $this->hasMany(MenuItem::class,'pid','id')->orderBy('order');
    }
}
