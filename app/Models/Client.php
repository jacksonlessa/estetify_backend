<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name','email','phone','document','birthdate','account_id',
        'address','neighborhood','city','state','postal_code'
    ];
    
    /**
     * Get the account that owns the client.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }


    public function setBirthdateAttribute($timestampTz)
    {   
        $timestamp = new Carbon($timestampTz);
        $timestamp->subHour(3); // fix timezone
        $this->attributes['birthdate'] = $timestamp;
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
            $query->orWhere('email', 'like', '%'.$search.'%');
            $query->orWhere('document', 'like', '%'.$search.'%');
            $query->orWhere('phone', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['phone'] ?? null, function ($query, $search) {
            $query->where('phone', 'like', '%'.$search.'%');
        })->when($filters['document'] ?? null, function ($query, $search) {
            $query->where('document', 'like', '%'.$search.'%');
        })->when($filters['email'] ?? null, function ($query, $search) {
            $query->where('email', 'like', '%'.$search.'%');
        })->when($filters['account_id'] ?? null, function ($query, $account) {
            $query->where('account_id', $account);
        });
    }
}
