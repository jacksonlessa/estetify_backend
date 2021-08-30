<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->account->users()
            ->orderBy('name')
            ->filter(Request::only('search', 'trashed'))
            ->paginate()
            ->appends(Request::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request   
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $inputs = $request->validated();

        $resource = Auth::user()->account->users()->create($inputs);

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
        $user = Auth::user()->account->users()->withTrashed()->find($id);
        
        if(!$user)
        return response(
            ['message' => 'insufficient permission']
            ,403);
    
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user =  Auth::user()->account->users()->find($id);

        if(!$user)
            return response(
                ['message' => 'insufficient permission']
                ,403);

        $inputs = $request->validated();

       
        if($user->update($inputs))
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
        $user =  Auth::user()->account->users()->find($id);

        if(!$user)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        if($user->delete())
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
        $user =  Auth::user()->account->users()->withTrashed()->find($id);

        if(!$user)
            return response(
                ['message' => 'insufficient permission']
                ,403);

        if($user->restore())
            return response(
                ['message' => 'resource restored']
                ,200);
    }
}
