<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginAuthRequest $request){

        return response()->json('Hello');
        // $validatedCredentials = $request->validated();
        // $user = User::where("email", $validatedCredentials["email"])->first();

        // return response()->json($user);

        // if(!$user || !Hash::check($request->password, $user->password)){
        //     return response()->json(["message"=> "The provided credentials are incorrect"], Response::HTTP_FORBIDDEN);
        // }
        
        // $token = $user->createToken($request->name)->plainTextToken;

        // return response()->json([
        //     "user" => $user,
        //     "token"=> $token,
        // ], Response::HTTP_OK);
    }

    public function register(RegisterAuthRequest $request){
        
        $validatedData = $request->validated();
        // $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::create($validatedData);

        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json([
            "status"  => "success",
            "message" => "User successfully created.",
            "data"    => $user,
            "token"  => $token,
        ], Response::HTTP_CREATED);


    }

    public function logout(Request $request){
        
        $request->user()->token()->delete();
        return response()->json([
            "message" => "You are logged out.",
        ]);
    }
}
