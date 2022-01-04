<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['original_price', 'price', 'professional_id', 'product_id', 'service_id'];
    

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
