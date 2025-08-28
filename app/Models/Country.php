<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $table = 'countries';
    public $timestamps = false;

    protected $fillable = [
        'iso2',
        'name',
        'status',
        'phone_code',
        'iso3',
        'region',
        'subregion',
    ];

    protected $casts = [
        'id'         => 'integer',
        'status'     => 'boolean',
        'phone_code' => 'string',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
