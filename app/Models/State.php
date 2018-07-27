<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $country_id
 * @property $state_code
 * @property $state_name
 */
class State extends Model {
    public $timestamps = false;
    protected $primaryKey = false;
}