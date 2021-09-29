<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Display current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return Auth::user()->load('account');
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
}
