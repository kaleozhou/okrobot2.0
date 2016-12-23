<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){
        $user=$request->user();
        return view('modifyUserinfo',['user'=>$user]);
    }
    public function modify(Request $request){
        $data=$request->all();
        $user=$request->user();
        $user->api_key=$data['api_key'];
        $user->secret_key=$data['secret_key'];
        $user->cost=$data['cost'];
        $user->save(); 
        return view('modifyUserinfo',['user'=>$user]);
    }


}
