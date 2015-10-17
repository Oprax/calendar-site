<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Reservation extends Model
{
    protected $fillable = ['email', 'name', 'forename', 'arrive_at', 'leave_at', 'nb_people', 'is_valid'];

    public function scopePublished($query)
    {
        return $query->where('is_valid', true);
    }

    public function getArriveAtAttribute($value)
    {
        if(is_string($value)) {
            return Carbon::parse($value);
        }
        return $value;
    }

    public function setArriveAtAttribute($value)
    {
        $this->attributes['arrive_at'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getLeaveAtAttribute($value)
    {
        if(is_string($value)) {
            return Carbon::parse($value);
        }
        return $value;
    }

    public function setLeaveAtAttribute($value)
    {
        $this->attributes['leave_at'] = Carbon::createFromFormat('d/m/Y', $value);
    }
}
