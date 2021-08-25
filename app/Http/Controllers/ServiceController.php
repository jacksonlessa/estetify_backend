<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->account->services()
            ->orderBy('name')
            ->filter(Request::only('search', 'trashed'))
            ->paginate()
            ->appends(Request::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $resource = Auth::user()->account->services()->create(
            $request->validated()
        );

        return response($resource,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Auth::user()->account->services()->withTrashed()->find($id);
        
        if(!$service)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        return $service;
        // return Service::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ServiceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        $service =  Auth::user()->account->services()->find($id);

        if(!$service)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        if($service->update($request->validated()))
            return response(
                ['message' => 'resource updated']
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
        $service =  Auth::user()->account->services()->find($id);

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
        $service =  Auth::user()->account->services()->withTrashed()->find($id);

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