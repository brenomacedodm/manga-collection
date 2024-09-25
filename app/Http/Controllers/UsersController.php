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
     *          @OA\JsonContent(
     *              required={"name", "email", "password", "password_confirmation"},
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="password_confirmation", type="string"),
     *          ),
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

    public function changePassword(Request $request){
        if(!$request->user()){
            return response()->json([
                'status' => false,
                'message' => 'You must be logged to change your password', 
                'data' => []
            ]);
        }

        $fields = $request->validate([
            'old_password' => 'required', 
            'password' => 'required|confirmed'
        ]);

        if(Hash::check($fields['old_password'], $request->user()->password)){
            $request->user()->forceFill([
                "password" => Hash::make($fields['password'])
            ])->save();

            $request->user()->tokens()->delete();

        }

        return response()->json([
            'status' => true,
            'message' => "Your password was changed. You'll have to log in again", 
            'data' => []
        ]);

    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Users"},
     *     summary="Login",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *          ),
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
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *          ),
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
    public function setAdmin(Request $request, $id)
    {  
        if(!$request->isAdmin) return response( 
            [
                "status" => false,
                'message' => "You don't have permission to give admin access",
                'data' => []
            ],
             499
            );


        $user = User::find($id);
        $user->is_admin = 1;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => "{$user['name']} is now an admin",
            'data' => []
        ]);
    }
}
