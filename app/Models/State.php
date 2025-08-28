<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;

    protected $table = 'states';
    public $timestamps = false;

    protected $fillable = [
        'country_id',
        'name',
        'country_code',
    ];

    protected $casts = [
        'id'         => 'integer',
        'country_id' => 'integer',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
