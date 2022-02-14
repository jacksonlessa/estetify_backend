<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $accountId = Auth::user()->account_id;
        
        // return Provider::where("account_id", $accountId)
        return Provider::orderBy('name')
            ->filter(Request::only('search', 'trashed'))
            ->paginate()
            ->appends(Request::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProviderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderRequest $request)
    {

        $resource = Auth::user()->account->providers()->create(
            $request->validated()
        );

        return response([
            'message' => 'resource created',
            "data" => $resource
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provider = Auth::user()->account->providers()->withTrashed()->find($id);
        
        if(!$provider)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        return $provider;
        // return Service::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProviderRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderRequest $request, $id)
    {
        $provider =  Auth::user()->account->providers()->find($id);

        if(!$provider)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        if($provider->update($request->validated()))
            return response(
                [
                    'message' => 'resource updated',                    
                    "data" => $provider
                ]
                ,200);
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service =  Auth::user()->account->providers()->find($id);

        if(!$service)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        if($service->delete())
            return response(
                ['message' => 'resource deleted']
                ,200); 

        //
    }
    
    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $service =  Auth::user()->account->providers()->withTrashed()->find($id);

        if(!$service)
            return response(
                ['message' => 'insufficient permission']
                ,403);

        if($service->restore())
            return response(
                ['message' => 'resource restored']
                ,200);
    }
}