<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use DB;

class PageControl extends Controller{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request){
        $this->request = $request;
        //
    }

    public function login(){
        return view('page.login');
    }

    public function getLogUser(){

        $username = $_GET['username'];
        $password = $_GET['password'];
        $isFound = false;

        $users = User::all();

        if(empty($users)){
            return "Empty";
        }

        foreach($users as $user){
            $use = $user->username;

            if($use == $username){
                $pass = $user->password;

                if ($pass == $password){
                    $isfound=true;
                    return "You have successfully logged in!";
                break;
                }
            }
        }
        if(!$isFound) return response()->json(("Username or Password is invalid!"),404);
    }

}