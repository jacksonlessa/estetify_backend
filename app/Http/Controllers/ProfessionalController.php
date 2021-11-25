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
        return Auth::user()->account->users()
            ->orderBy('name')
            ->filter(Request::only('search', 'trashed'))
            ->whereIn('role', ['admin','professional'])
            ->paginate()
            ->appends(Request::all());
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
        $professional = Auth::user()->account->users()->withTrashed()->find($id);
        
        if(!$professional)
            return response(
                ['message' => 'insufficient permission']
                ,403);
        
        return $professional;
    }
}
