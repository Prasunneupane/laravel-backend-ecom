<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request){
        // echo 'a';die;
        // return $request->all();

        try {
            $validatedData = $request->validate([
                'name'=>'required',
                'email'=>'required|email'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // return validation error response
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
        $register= new User();
        $register->name=$request->input('name');
        $register->password=$request->input('password');
        $register->email=$request->input('email');
        $register->save();

        if($register){
            // $data= User::find($register);
            $data = User::find($register->id);
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }
        else{
            return response()->json([
                'success'=>false,
            ]);
        }

    }
    public function login(Request $req){
            $user=User::where('email','=',$req->email)->first();
            if(!$user || $user->password !=$req->password ){
                return response()->json([
                    "status"=>"error",
                    "error"=>'Email or Password is not correct'
                ]);
            }else{
                return response()->json([
                    "status"=>"success",
                    "data"=>$user
                ]);
            }

    }
}
