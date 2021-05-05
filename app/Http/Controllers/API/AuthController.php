<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Validator;
use Gate;
use Auth;
use Seshac\Otp\Otp;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:10|min:10|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'mobile' => $request->get('mobile'),
            'roles' => $request->get('roles'),
            'password' => Hash::make($request->get('password')),
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return json_encode(['user' => $user, 'access_token' => $accessToken]);
    }
    public function getOTP(Request $request)
    {
        $mob = $request->mobile;
        $user = User::where('mobile', '=', $mob)->first();
        if ($user && is_numeric($mob)) {
            $otp = Otp::generate($mob);
            return json_encode($otp);
        } else {
            return json_encode(['MSG' => "Mobile No Not Registerd Please Register Yourself."]);
        }
    }
    public function verifyOTP(Request $request)
    {
        $mob = $request->mobile;

        if (is_numeric($mob)) {
            $verify = Otp::validate($mob, $request->otp);
            if ($verify->status) {
                $user = User::where('mobile','=',$mob)->first();
                if (Gate::allows('is-admin')) {
                    if (Auth::attempt(array('mobile' => $mob, 'password' => $request->password))) {
                        $accessToken = $user->createToken('authToken')->accessToken;
                        return json_encode(['MSG' => "Admin Login Successful.", 'access_token' => $accessToken]);
                    }
                }
                else{
                    $accessToken = $user->createToken('authToken')->accessToken;
                    return json_encode(['MSG' => "Login Successful.", 'access_token' => $accessToken]);
                }
            } else {
                return json_encode($verify);
            }
        } else {
            return json_encode(['MSG' => "Invild mobile no Please Try Again"]);
        }
    }
}
