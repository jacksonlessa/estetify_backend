<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'professional_id', 'account_id', 'scheduled_at', 'total'];
    
    
    public function setScheduledAtAttribute($timestampTz)
    {   
        $timestamp = new Carbon($timestampTz);
        $timestamp->subHour(3); // fix timezone
        $this->attributes['scheduled_at'] = $timestamp;
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service', "order_items", 'order_id', 'service_id')->withPivot([
            'quantity',
            'original_price',
            'price',
            'created_at',
            'updated_at',
        ]);
    }
    public function products()
    {
        return $this->belongsToMany('App\Models\Products', "order_items", 'order_id', 'product_id')->withPivot([
            'quantity',
            'original_price',
            'price',
            'created_at',
            'updated_at',
        ]);
    }
    // public function order_items(){
    //     return $this->hasMany('App\Models\OrderItem');
    // }
}
