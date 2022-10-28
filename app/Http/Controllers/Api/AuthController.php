<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->All();

        // $this->validate($request, [
        //     'name' => 'required|max:60',
        //     'email' => 'required|email:rfc,dns|unique:users',
        //     'password' => 'required'
        // ]);

        

        // // $this->validate($registrationData, [
        // //     'name' => 'required|max:60',
        // //     'email' => 'required|email:rfc,dns|unique:users',
        // //     'password' => 'required'
        // // ]);

        $validate = Validator::make($registrationData,[
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response(['message'=> $validate->errors()],400);
        }

        $registrationData['password'] = bcrypt($request->password);

        $user = User::create($registrationData);

        return response([
            'message' => 'Register Success',
            'user' => $user 
        ],200);


    }

    public function login(Request $request)
    {
        $loginData = $request->all();

        $validate = Validator::make($loginData,[
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->error()],400);
        }

        if (!Auth::attempt($loginData)) {
            return response(['message'=> 'Invalid Credential'],401);
        }

         /** @var \App\Models\User $user **/
        $user = Auth::user();
        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);

    }

    public function logout(Request $request)
    {
        
        try {
             /** @var \App\Models\User $user **/
            $user = $request->user()->token();
            $user->revoke();

            return response([
                'message' => 'Logout berhasil'
            ],200);
        } catch (\Exception $e) {
            return response([
                'message' => 'Logout gagal/error ' . $e->getMessage(),
            ],500);
        }
        

    }
}
