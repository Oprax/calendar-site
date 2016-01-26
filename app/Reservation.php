<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Reservation extends Model
{
    protected $fillable = ['email', 'name', 'forename', 'arrive_at', 'leave_at', 'nb_people', 'is_valid'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_valid' => 'boolean',
        'nb_people' => 'integer',
        'id' => 'integer',
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_valid', true);
    }
}
