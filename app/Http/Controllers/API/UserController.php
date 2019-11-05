<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'      =>    'required|string|max:191',
            'email'     =>    'required|string|email|max:191|unique:users',
            'password'  =>    'required|string|min:6'
        ]);

        return User::create([
            'name' => $request['name'],
            'email'=>$request['email'],
            'password'=> bcrypt($request['password']),
            'photo'=>$request['photo'] ?? 'profile.png',
            'bio'=>$request['bio'],
            'type'=>$request['type'] ?? 'user',
        ]);
    }


    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        return $request->photo;
        // return ['message'=>'Success'];
    }
    public function profile()
    {
        return auth('api')->user();
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
        $user = User::findOrFail($id);

        
        $request->validate([
            'name'      =>    'required|string|max:191',
            'email'     =>    'required|string|email|max:191|unique:users,email,'.$user->id,
            'password'  =>    'sometimes|min:6'
        ]);


        $user->update($request->all());


        return ['message'=> 'Updated the User info!'];
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
        $user= User::findOrFail($id);
        
        
        $user->delete();
        
        return ['message'=>'User Deleted'];
    }
}
