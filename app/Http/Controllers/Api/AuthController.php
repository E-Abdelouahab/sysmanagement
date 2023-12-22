<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $fields = $request->validate([
    //         'email'=>'required|string',
    //         'password'=>'required|string'
    //     ]);

    //     //check email
    //     $user = User::where('email', $fields['email'])->first();
    //     //check password
    //     if(!$user || !Hash::check($fields['password'], $user->password)){
    //         return response([
    //             'message'=>'password is not correct'
    //         ],401);
    //     }

    //     $token = $user->createToken('myapptoken')->plainTextToken;
    //     $response = [
    //         'user'=>$user,
    //         'token'=>$token
    //     ];

    //     return response($response,201);
    // }


    public function login(Request $request)
    {
        $fields = $request->validate([
            'credential' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where(function ($query) use ($fields) {
            $query->where('email', $fields['credential'])
                ->orWhere('phone', $fields['credential'])
                ->orWhere('cin', $fields['credential']);
        })->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            auth()->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return [
                'message' => 'Logged out'
            ];
        } else {
            return [
                'message' => 'User is not authenticated'
            ];
        }
    }

    public function create(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'fullName' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }else{
                
            $user = User::create([
                'fullName' => $request->fullName,
                'cin' => $request->cin,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'dateN' => $request->dateN,
                'sexe' => $request->sexe,
                'role' => $request->role,
            ]);

            if($user){
                return response()->json([
                    'status' => 200,
                    'message' => 'user created successfully',
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong',
                ], 500);
            }

        }
    }

}
