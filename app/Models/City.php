<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
  use SoftDeletes;

    protected $table = 'cities';
    public $timestamps = false;

    protected $fillable = [
        'country_id',
        'state_id',
        'name',
        'country_code',
    ];

    protected $casts = [
        'id'         => 'integer',
        'country_id' => 'integer',
        'state_id'   => 'integer',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
