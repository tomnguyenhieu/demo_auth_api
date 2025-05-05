<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\UserResource;
use App\Models\Information;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$params = $request->all();
		$user = User::where('email', $params['email'])
			->first();

		if (Hash::check($params['password'], $user->password)) {
			return ApiResponse::success(new UserResource($user));
		} else {
			return ApiResponse::dataNotfound();
		}
	}

	public function register(Request $request)
	{
		$params = $request->all();
		$user = User::create([
			'name' => $params['name'],
			'email' => $params['email'],
			'password' => Hash::make($params['password']),
		]);
		return ApiResponse::success(new UserResource($user));
	}
}
