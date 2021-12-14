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
        $hoje = Order::whereIn("status", ['open','closed']);
        $week = Order::whereIn("status", ['open','closed']);
        $resource = [
            "orders" => [
                "day" => 1,
                "week" => 1,
            ],
            "sales" => [
                "day" => "R$ 770,00",
                "month" => "R$ 7.770,00"
            ]
        ];

        return response($resource,201);
    }
}