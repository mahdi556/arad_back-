<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\userShopsResource;
use App\Models\User;
use App\Notifications\OTPsms;
use CreateExpoPushNotificationsTable;
use Exception;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    public function register(Request $request)
    {

       


        $request->validate([
            'cellphone' => 'required'
        ]);
        try {

            $user = User::all()->where('cellphone', $request->cellphone)->first();
            //            $OTPCode = 1111;
            $OTPCode = mt_rand(1111, 9999);

               
 
            if ($user) {
                $token = $user->createToken('myApp')->plainTextToken;

                $user->update([
                    'otp' => $OTPCode,
                ]);
                $user->login_token = $token;
                $user->save();
            } else {
                
                $user = User::Create([
                    'cellphone' => $request->cellphone,
                    // 'otp' => $OTPCode,
                ]);
                // $token = $user->createToken('myApp')->plainTextToken;
                // $user->login_token = $token;
                $user->save();
            }
            // $user->notify(new OTPsms($OTPCode, $user->cellphone));
              dd('ok');
            return response(['login_token' => $token, 'message' => 'ثبت نام با موفقیت انجام شد'], 200);
        } catch (\Exception $ex) {
            return response(['errors' => $ex->getMessage()], 422);
        }
    }


    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:4',
            'login_token' => 'required',
            'cellphone' => 'required',

        ]);

        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();

            if ($request->otp == 1111) {
                auth()->login($user, $remember = true);
            } else {
                return response(['errors' => ['otp' => ['کد تاییدیه نادرست است']]], 422);
            }
        } catch (\Exception $ex) {
            return response(['errors' => $ex->getMessage()], 422);
        }
    }
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json('user not found', 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json('password is incorrect', 404);
        }

        $token = $user->createToken('myApp')->plainTextToken;


        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // public function registerCell()
    // {
    //     $tokens = PushToken::all()->pluck('token')->toArray();


    //  }
    // public function pushToken(Request $request)
    // {
    //     $pushToken = PushToken::all()->where('token', $request->push_token)->first();
    //     if (!$pushToken) {
    //         PushToken::create([
    //             'token' => $request->push_token,
    //             'user_id' => $request->user_id
    //         ]);
    //     }
    //     $user_token = $request->user_token;
    //     if ($user_token != null) {
    //         $user = User::where('login_token', $user_token)->first();

    //         return  [
    //             'user' => new UserResource($user), 'shops' => userShopsResource::collection($shops->load('category')), 200
    //         ];
    //     } else {
    //         return response()->json([
    //             'message' => 'success'
    //         ], 200);
    //     } 
    // }
}
