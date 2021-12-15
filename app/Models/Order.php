<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'user_id', 'account_id', 'scheduled_at', 'status', 'total', 'payment_method', 'observation'];
    
    
    public function setScheduledAtAttribute($timestampTz)
    {   
        $timestamp = new Carbon($timestampTz);
        $timestamp->subHour(3); // fix timezone
        $this->attributes['scheduled_at'] = $timestamp;
    }

    public function scopeFilter($query, array $filters)
    {
        // SEARCH
        $query->when($filters['search'] ?? null, function ($query, $search) {
            // $query->
            $query->whereHas('client', function ($query) use ($search){
                return $query->where('name' , 'like', '%'.$search.'%');
            })->orWhereHas('professional', function ($query) use ($search) {
                return $query->where('name' , 'like', '%'.$search.'%');
            });
        // TRASH
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        // Nome do Cliente
        })->when($filters['client_name'] ?? null, function ($query, $search) {
            $query->whereHas('client', function ($query) use ($search){
                return $query->where('name' , 'like', '%'.$search.'%');
            });
        // Nome do Profissional
        })->when($filters['professional_name'] ?? null, function ($query, $search) {
            $query->whereHas('professional', function ($query) use ($search) {
                return $query->where('name' , 'like', '%'.$search.'%');
            });
        // Nome do Profissional
        })->when($filters['schedule_range'] ?? null, function ($query, $dates) {
            $init = Carbon::parse($dates[0]);
            $init->hour=0;
            $init->minute=0;
            $init->second=0;
            $end = Carbon::parse($dates[1]);
            $end->hour=23;
            $end->minute=59;
            $end->second=59;
            $query->whereBetween('scheduled_at', [$init,$end]);
        })->when($filters['account_id'] ?? null, function ($query, $account) {
            $query->where('account_id', $account);
        });
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service', "order_items", 'order_id', 'service_id')->withPivot([
            'original_price',
            'price',
            'professional_id',
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
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function professional(){
        return $this->belongsTo(User::class, 'user_id');
    }


    //SCOPED QUERIES
    /**
     * Scope a query to only include orders are not canceled.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeValid($query){
        return $query->whereIn('status', ['opened','closed']);
    }
    public function scopeOpened($query){
        return $query->where('status', 'opened');
    }
    public function scopeClosed($query){
        return $query->where('status', 'closed');
    }

    public function scopeToday($query){
        $today = Carbon::now();

        return $query->whereDate('scheduled_at', $today->format('Y-m-d'));
    }
    public function scopeWeek($query){
        $monday = Carbon::now()->startOfWeek();
        $sunday = Carbon::now()->endOfWeek();
        return $query->whereBetween('scheduled_at', [$monday->format('Y-m-d'), $sunday->format('Y-m-d')]);
    }
    public function scopeMonth($query){
        $first = Carbon::now()->startOfMonth();
        $last = Carbon::now()->endOfMonth();
        return $query->whereBetween('scheduled_at', [$first->format('Y-m-d'), $last->format('Y-m-d')]);
    }
}
