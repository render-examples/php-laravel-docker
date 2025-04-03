<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getUsersByNamePrefix(Request $request){
        $name_prefix = $request->name_prefix;
        $users = User::where('name', 'like', $name_prefix.'%')
                        ->where('id', '!=', $request->user()->id)
                        ->get();

        return response()->json($users);
    }

    public function getUserById(Request $request){
        $user_id = (int) $request->user_id; 
        $user = User::where('id', $user_id)->first();

        return response()->json($user);
    }
}
