<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $customer_id
 * @property string $email
 * @property string $token
 * @property Carbon $expiry_date
 */
class ResetToken extends Model
{
    protected $guarded = [];
    public $timestamps = false;
}
