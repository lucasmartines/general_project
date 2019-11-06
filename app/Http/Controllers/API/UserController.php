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
        $this->authorize("isAdmin");
        return User::latest()->paginate(20);
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
      
        $request->validate([
            'name'      =>    'required|string|max:191',
            'email'     =>    'required|string|email|max:191|unique:users,email,'.$user->id,
            'password'  =>    'sometimes|required|min:6'
        ]);


        $currentPhoto = $user->photo;
        /**if the photo in database is diferent fron this phtoto, then post */
        if($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];
            
            \Image::make($request->photo)->save(public_path('img/profile/').$name); 

            $request->merge(['photo' => $name ]);

            $user_photo = public_path('img/profile/').$currentPhoto;

            if( file_exists( $user_photo )){
                @unlink($user_photo);
            }
        }

        if(!empty($request->password)){
            $request->merge(['password' => bcrypt($request->password)]);
          
        }
        $user->update($request->all());
        
        return ['message'=>'Success'];
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

        if(!empty($request->password)){
            $request->merge(['password' => bcrypt($request->password)]);
          
        }

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

        $this->authorize("isAdmin");
        $user= User::findOrFail($id);
        
        
        $user->delete();
        
        return ['message'=>'User Deleted'];
    }
    private function validation(){
        return [
            'name'      =>    'required|string|max:191',
            'email'     =>    'required|string|email|max:191|unique:users',
            'password'  =>    'required|string|min:6'
        ];
    }
}
