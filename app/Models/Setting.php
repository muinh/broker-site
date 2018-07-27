<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 */
class Setting extends Model
{
    protected $table = 'settings';

    protected $guarded = [];

    public $timestamps = false;
}
