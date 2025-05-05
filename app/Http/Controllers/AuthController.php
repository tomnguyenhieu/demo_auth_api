<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$params = $request->all();
		$user = User::where('email', $params['email'])->first();
		if (Hash::check($params['password'], $user->password)) {
			$user->token = $user->createToken($user->email);
			return ApiResponse::success(new AuthResource($user));
		} else {
			return ApiResponse::dataNotfound();
		}
	}

	public function register(Request $request)
	{
		$params = $request->all();
		User::insert([
			'name' => $params['name'],
			'email' => $params['email'],
			'password' => Hash::make($params['password']),
		]);
		return ApiResponse::success();
	}

	public function logout(Request $request)
	{
		$request->user()->tokens()->delete();
		return ApiResponse::success();
	}
}
