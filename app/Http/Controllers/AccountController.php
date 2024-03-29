<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\PlanSelectRequest;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAccountRequest $request)
    {
        $fields = $request->validated();
        if ($fields['activity'] == 'Outro')
            $fields['activity'] = $fields['other_activity'];
        
        $resource = Account::create($fields);

        $resource->save();

        $user = Auth::user();
        $user->account_id= $resource->id;
        $user->save();


        // SETUP ACCOUNT 
        // Update Account Plan
        $resource->plan_id = 1;
        $resource->features = '{"products":20,"services":true,"professionals":1}';
        $resource->save();

        // Create First Professional
        $professional = Auth::user()->account->professionals()->create([
            'name' => $user->name
        ]);

        // Send Welcome Notification
        $user->notify(new WelcomeNotification($user, $resource));

        return response($resource,201);
    }

    public function storePlan(PlanSelectRequest $request)
    {
        $fields = $request->validated();
        $account = Account::findOrFail(Auth::user()->account_id);

        $account->plan_id = $fields['id'];
        $account->features = ($fields['features']);

        $account->save();
        
        return response($account,200);
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
