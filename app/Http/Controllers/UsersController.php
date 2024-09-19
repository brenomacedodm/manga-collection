<?php

namespace App\Http\Controllers;
use App\Models\User;


use Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return '';
    }
    
    public function register(Request $request)
    {
        $user = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($user);

        $token = $user->createToken($request->name);

        return [
            'status' => true, 
            'message'=> 'User created successfully',
            'token' => $token->plainTextToken
        ];
    }

    public function verifyEmail(Request $request){
        
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return [
                'status' => false,
                'message' => 'The provided credentials are incorrect'
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'status' => true, 
            'message'=> 'You are logged in',
            'token' => $token->plainTextToken
        ];
    }
    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        return [
            'status' => true, 
            'message'=> 'You are logged out'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
