<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name', 'description', 'price', 'duration'];
    
    /**
     * Get the account that owns the service.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
