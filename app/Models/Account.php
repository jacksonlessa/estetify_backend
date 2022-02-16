<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'features' => 'array'
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'document', 'activity',
        'phone'
    ];
    
    /**
     * Get the users for the account.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the services for the account.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the professionals for the account.
     */
    public function professionals()
    {
        return $this->hasMany(Professional::class);
    }

    /**
     * Get the clients for the account.
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Get the clients for the account.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the clients for the account.
     */
    public function providers()
    {
        return $this->hasMany(Provider::class);
    }
}
