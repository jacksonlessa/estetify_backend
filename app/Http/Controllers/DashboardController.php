<?php

namespace App\Http\Controllers;

use App\Models\Account;
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
        $resource = [
            "orders" => [
                "day" => 10,
                "week" => 45,
            ],
            "sales" => [
                "day" => "R$ 770,00",
                "month" => "R$ 7.770,00"
            ]
        ];

        return response($resource,201);
    }
}