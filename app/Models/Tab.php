<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 */
class Tab extends Model
{
    public $timestamps = false;

    public function tabItems()
    {
        return $this->hasMany(TabItem::class)
            ->orderBy('tab_items.order', 'asc');
    }
}
