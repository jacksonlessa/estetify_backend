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
        $todayOrders = Order::valid()->today()->count();
        $weekOrders = Order::valid()->week()->count();
        $salesDay = Order::closed()->today()->sum('total');
        $salesMonth = 0;
        if(Auth::user()->role=='admin')
            $salesMonth = Order::closed()->month()->sum('total');
        
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