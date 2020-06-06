<?php

namespace App\Http\Controllers\APIW;

use Illuminate\Http\Request;
use App\Admin;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function login(Request $request) {
        $user = Admin::where('email', $request->email)->get()->first();
        if ($user && ($request->password == $user->password)) // The passwords match...
        {
            $response = ['success'=>true, 'data'=>$user];
        }
        else
            $response = ['success'=>false, 'data'=>'Credentials Does not Match Our Data'];


        return response()->json($response, 201);
    }
}
