<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $FirstName
 * @property $LastName
 * @property $passport
 * @property $creditCardFront
 * @property $creditCardBack
 * @property $utilityBill
 */
class DocsData extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = false;
    protected $guarded = [];

    public $id;
    public $FirstName;
    public $LastName;

    public $passport;
    public $creditCardFront;
    public $creditCardBack;
    public $utilityBill;
}