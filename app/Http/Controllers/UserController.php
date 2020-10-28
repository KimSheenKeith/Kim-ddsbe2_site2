<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Traits\ApiResponser;
use DB;
Class UserController extends Controller {
    use ApiResponser;

    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }


    //To Show all users in the database
    public function getUsers(){
        $users = DB::connection('mysql')
        ->select("Select * from tbluser");
        return response()->json($users, 200);
    }



    //Search user in database
    public function getUser($id){
        $user= User::find($id);
        if($user == null) return response()->json('User does not exist!', 404);
        return response()->json($user,200);
    }


    // Create a new user
    public function addUsers(Request $request){

        $rules = [
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ];

        $this->validate($request,$rules);

        $users =User::create($request->all());

        
        return $this->successResponse($users,Response::HTTP_CREATED);
    }

    //Update existing user

    public function updateUsers(Request $request,$id){
        $rules = [
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ];

        $this->validate($request,$rules);

        $user = User::find($id);

        if ($user == null)return response()->json('Invalid User!', 404);

        $user->fill($request->all());

        $user->save();

        print ("User has been successfully updated!");

        return $this->successResponse($user);
    }

    // Delete existing user
    
    public function deleteUsers($id){
        User::findOrFail($id)->delete();

        return response()->json('User has been successfully deleted!', 200);
    }





}