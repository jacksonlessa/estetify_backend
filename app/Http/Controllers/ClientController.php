<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->account->clients()
            ->orderBy('name')
            ->filter(Request::only('search', 'trashed'))
            ->paginate()
            ->appends(Request::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        Auth::user()->account->clients()->create(
            $request->validated()
        );

        return response(['resource created'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Auth::user()->account->clients()->withTrashed()->find($id);
        
        if(!$client)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        $client =  Auth::user()->account->clients()->find($id);

        if(!$client)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        if($client->update($request->validated()))
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
        $client =  Auth::user()->account->clients()->find($id);

        if(!$client)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        if($client->delete())
            return response(
                ['message' => 'resource deleted']
                ,200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $client =  Auth::user()->account->clients()->withTrashed()->find($id);

        if(!$client)
            return response(
                ['message' => 'insufficient permission']
                ,403);

        if($client->restore())
            return response(
                ['message' => 'resource restored']
                ,200);
    }
}
