<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Jobs\OtpJob;
use App\Models\User;
use App\Notifications\OTPsms;
use CreateExpoPushNotificationsTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends ApiController
{
    public function register(Request $request)
    {
        $request->validate([
            'cellphone' => 'required'
        ]);
            $user = User::where('cellphone', $request->cellphone)->first();
            $OTPCode = mt_rand(1111, 9999);
            $loginToken = Hash::make('DCDCojncd@cdjn%!!ghnjrgtn&&');

            if ($user) {
                $user->update([
                    'otp' => $OTPCode,
                    'login_token' => $loginToken
                ]);
                $user->login_token = $loginToken;
                $user->save();
            } else {
                $user = User::Create([
                    'cellphone' => $request->cellphone,
                    'otp' => $OTPCode,
                    'login_token' => $loginToken
                ]);
                $user->login_token = $loginToken;
                $user->save();
            }

            // OtpJob::dispatch($OTPCode, $user);
            // $user->notify(new OTPsms($OTPCode, $user->cellphone));

            return $this->successResponse(['login_token' => $user->login_token], 200);
    }


    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:4',
            'login_token' => 'required',
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->firstOrFail();

            // if ($request->otp == $request->otp) {
            if ($request->otp == 1111) {
                // auth()->login($user, $remember = true);
                $token = $user->createToken('myApp', ['user'])->plainTextToken;
                // return response(['success' => ['otp' => ['کد تاییدیه درست است']],'new'=>$user->new], 200);
                $user->remember_token = $token;
                $user->save();
                return $this->successResponse([
                    'user' => new UserResource($user),
                    'token' => $token
                ], 200);
            } else {
                return response(['errors' => ['otp' => ['کد تاییدیه نادرست است']]], 422);
            }
        } catch (\Exception $ex) {
            return response(['errors' => $ex->getMessage()], 422);
        }
    }
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $user = User::where('login_token', $request->login_token)->firstOrFail();
        $OTPCode = mt_rand(1111, 9999);
        $loginToken = Hash::make('DCDCojncd@cdjn%!!ghnjrgtn&&');

        $user->update([
            'otp' => $OTPCode,
            'login_token' => $loginToken
        ]);
        $user->login_token = $loginToken;
        $user->save();

        // $user->notify(new OTPSms($OTPCode));

        return $this->successResponse(['login_token' => $loginToken], 200);
    }

    public function firstSignUp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'role' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = User::find(auth()->user()->id);
        if (!$user) {
            return response()->json('user not found', 404);
        }

        // if (!Hash::check($request->password, $user->password)) {
        //     return response()->json('password is incorrect', 404);
        // }

        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;

        $user->new = 0;
        $user->save();
        $user->syncRoles($request->role);
        return $this->successResponse([
            'user' => new UserResource($user),
        ], 200);
    }
    public function me()
    {
        $user = User::find(Auth::id());
        return $this->successResponse([
            'user' =>  new UserResource($user)
        ], 200);
    }

    public function loginOffice(Request $request)
    {
        $user = User::where('cellphone', $request->cellphone)->first();
        if (!$user) {
            return response()->json('user not found', 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json('password is incorrect', 401);
        }

        $token = $user->createToken('myApp')->plainTextToken;
        $user->login_token = $token;
        $user->save();

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

}
