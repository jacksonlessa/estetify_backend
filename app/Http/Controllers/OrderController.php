<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Generate a basic list of dates determined by professional config
        // $period  = CarbonPeriod::create('now', '2 days');
        $startDate = Carbon::now();
        $endDate = Carbon::now();
        $endDate->addDays(15);
        $period = CarbonPeriod::create($startDate, $endDate);

        $dates = [];
        foreach ($period as $date) {
            $date->hour = 0;
            $date->minute = 0;
            $date->second = 0;
            $dates[$date->format('m-d')] = [
                "local" => $date->toDateTimeLocalString(),
                "iso" => $date->format(DateTime::ISO8601),
                "date" => $date->format('Y-m-d H:i:s'),
                "availableTimes" => []
            ];
            $availableTimes = [];
            $date->hour = 8;
            for($i=0; $i <=12;$i++){
                $availableTimes[] = $date->format('Y-m-d H:i:s');
                $date->addMinutes(30);
            }
            $dates[$date->format('m-d')]["availableTimes"] = $availableTimes;
        }


        // Get all Professional current scheduled events


        // Merge two arrays
        return response($dates);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request) 
    {
        $inputs = $request->validated();
        $inputs['account_id'] = Auth::user()->account_id;

        // dd($inputs);
        $services = collect($inputs['services'])
            ->map(function($servicePrice) {
                return [
                    "original_price" => $servicePrice["original_price"],
                    "price" => $servicePrice["price"]
                ];
            });
        
        $order = Order::create($inputs);

        $order->services()->sync($services);
        return response($order,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}