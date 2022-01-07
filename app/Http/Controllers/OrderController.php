<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Support\Facades\Request;
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
        return Auth::user()->account->orders()
            ->with('professional', 'client', 'services')
            ->filter(Request::only('search', 'client_name', 'professional_name', 'init_date', 'end_date', 'canceled'))
            ->orderBy('scheduled_at')
            ->paginate()
            ->appends(Request::all());
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Order\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request) 
    {
        $inputs = $request->validated();
        $inputs['account_id'] = Auth::user()->account_id;
        $inputs['user_id'] = Auth::user()->account_id;

        // dd($inputs);
        

        $servicesInputs = [];
        foreach($inputs['services'] as $key => $servicePrice){
            $servicesInputs[] = [
                "original_price" => $servicePrice["original_price"],
                "price" => $servicePrice["price"],
                "professional_id" => $servicePrice["professional_id"],
                "service_id" => $key,
            ];
        }
        $services = [];
        foreach ($servicesInputs as $serviceInput){
            $service = new OrderItem();
            $service->fill($serviceInput);
            $services[]=$service; 
        }
        
        
        $order = Order::create($inputs);
        
        $order->services()->saveMany($services);

        $order->with('services');
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
        $order = Order::with(['services','client'])->where('account_id', Auth::user()->account_id)->find($id);

        if(!$order)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Order\UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        //
        $order = Order::with(['services'])->where('account_id', Auth::user()->account_id)->find($id);
        $inputs = $request->validated();

        if(isset($inputs['services'])){
            $servicesInputs = [];
            foreach($inputs['services'] as $key => $servicePrice){
                $servicesInputs[] = [
                    "original_price" => $servicePrice["original_price"],
                    "price" => $servicePrice["price"],
                    "professional_id" => $servicePrice["professional_id"],
                    "service_id" => $key,
                ];
            }
            $services = [];
            foreach ($servicesInputs as $serviceInput){
                $service = new OrderItem();
                $service->fill($serviceInput);
                $services[]=$service; 
            }
        }
        
        $order->update($inputs);

        if(isset($inputs['services'])){
            $order->services()->delete();
            $order->services()->saveMany($services);
            $order->refresh();
        }

        return response(
            ['message' => 'resource updated']
            ,200);
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

    public function bootstrap_schedule(){
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
}
