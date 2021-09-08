<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'professional_id', 'account_id', 'scheduled_at'];
    


    
    public function setScheduledAtAttribute($timestampTz)
    {   
        $timestamp = new Carbon($timestampTz);
        $timestamp->subHour(3); // fix timezone
        $this->attributes['scheduled_at'] = $timestamp;
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service')->withPivot([
            'price',
            'created_at',
            'updated_at',
        ]);
    }
}
