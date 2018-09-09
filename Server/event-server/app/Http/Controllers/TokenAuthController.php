<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
//use Tymon\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class TokenAuthController extends Controller
{
    protected function guard()
    {
        return Auth::guard('api');
    }

    public function authenticate(Request $request)
    {
    	$input = $request->only('email', 'password');
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

    	try {
    		if (! $token = JWTAuth::attempt($credentials)) {
    			return response()->json(['error' => 'invalid_credentials'], 401);
    		}
    	} catch (JWTException $e) {
    		return response()->json(['error' => 'could_not_create_token'], 500);
    	}

    	//if no errors return a jwt
    	return response()->json(compact('token'));
    }

    public function getAuthenticatedUser(Request $request)
    {
        //$user = JWTAuth::toUser($request->token);
        //return response()->json(['result' => $user]);
    	try {
    		if (! $user = JWTAuth::parseToken()->authenticate()) {
    			return response()->json(['user not found'], 404);
    		}
    	} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

    		return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

        	return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException  $e) {

        	return response()->json(['token_absent'], $e->getStatusCode());

    	}

    	return response()->json(compact('user'));
    }

    public function register(Request $request)
    {
    	$newuser = $request->all();

    	$password = Hash::make($request->input('password'));

        $newuser['password'] = $password;

        return User::create($newuser);
    }
}
