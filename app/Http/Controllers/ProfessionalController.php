<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfessionalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->account->professionals()
            ->orderBy('name')
            ->filter(Request::only('search', 'trashed'))
            ->paginate()
            ->appends(Request::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProfessionalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfessionalRequest $request)
    {
        //
        Auth::user()->account->professionals()->create(
            $request->validated()
        );

        return response(['Professional created'],201);
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
        $professional = Auth::user()->account->professionals()->withTrashed()->find($id);
        
        if(!$professional)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        return $professional;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProfessionalRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfessionalRequest $request, $id)
    {
        $professional =  Auth::user()->account->professionals()->find($id);

        if(!$professional)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        if($professional->update($request->validated()))
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
        $professional =  Auth::user()->account->professionals()->find($id);

        if(!$professional)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        if($professional->delete())
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
        $professional =  Auth::user()->account->professionals()->withTrashed()->find($id);

        if(!$professional)
            return response(
                ['message' => 'insufficient permission']
                ,403);

        if($professional->restore())
            return response(
                ['message' => 'resource restored']
                ,200);
    }
}
