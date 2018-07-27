<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $name
 * @property $code
 * @property $states
 */
class Country extends Model {
    public $timestamps = false;

    public function states()
    {
        return $this->hasMany(State::class);
    }
}