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
    
    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Users"},
     *     summary="Register",
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name", "email", "password", "password_confirmation"},
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *                  @OA\Property(property="password_confirmation", type="string"),
     *              )       
     *          )
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="User created successfully"
     *      ),
     *     @OA\Response(
     *          response=422, 
     *          description="Field Error"
     *      ),
     *     @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *     @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function register(Request $request)
    {
        $user = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($user);

        $token = $user->createToken($request->name);

        return response()->json([
            'status' => true, 
            'message'=> 'User created successfully',
            'data' => []
        ]);
    }

    public function verifyEmail(Request $request){
        
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Users"},
     *     summary="Login",
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"email", "password"},
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *              )       
     *          )
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Logged in successfully"
     *      ),
     *     @OA\Response(
     *          response=422, 
     *          description="Field Error"
     *      ),
     *     @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *     @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
     * )
     */
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
            'message' => 'You are logged in',
            'data' => [
                'token' => $token->plainTextToken
            ]
        ];
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Users"},
     *     summary="Logout",
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"email", "password"},
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *              )       
     *          )
     *      ),
     *     @OA\Response(
     *          response=200, 
     *          description="Logged out successfully"
     *      ),
     *     @OA\Response(
     *          response=422, 
     *          description="Field Error"
     *      ),
     *     @OA\Response(
     *          response=400, 
     *          description="Bad request"
     *      ),
     *     @OA\Response(
     *          response=404, 
     *          description="Resource Not Found"
     *      ),
     * )
     */
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
    public function update(Request $request, User $id)
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
