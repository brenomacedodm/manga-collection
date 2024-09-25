<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function sendMail(){
        \Mail::to(auth()->user())->send(new EmailVerification(auth()->user()));

        return response()->json([
            "status"=> true,
            "message"=> "Email verification link sent to your email",
            "data" => []
        ]);
    }

    public function verify(Request $request){
        if(!$request->user()->email_verified_at){
            $request->user()->forceFill([
                'email_verified_at' => now()
            ])->save();
        }

        return response()->json([
            "status"=> true,
            "message"=> "Email verified successfully",
            "data" => []
        ]);
    }
}
