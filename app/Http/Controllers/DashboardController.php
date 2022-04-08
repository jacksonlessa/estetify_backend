<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $account = Auth::user()->account;
        $todayOrders = $account->orders()->valid()->today()->count();
        $weekOrders = $account->orders()->valid()->week()->count();
        $salesDay = $account->orders()->valid()->today()->sum('total');
        $salesMonth = 0;
        if(Auth::user()->role=='admin')
            $salesMonth = $account->orders()->closed()->month()->sum('total');
        
        $resource = [
            "orders" => [
                "day" => $todayOrders,
                "week" => $weekOrders,
            ],
            "sales" => [
                "day" => $salesDay,
                "month" => $salesMonth
            ]
        ];

        return response($resource,201);
    }
}