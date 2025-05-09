<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\AuthResource;
use App\Mail\SendAuthCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now()
		]);
		return ApiResponse::success();
	}

	public function logout(Request $request)
	{
		$request->user()->tokens()->delete();
		return ApiResponse::success();
	}

	public function auth()
	{
		$code = rand(1000, 9999);
		Mail::to(auth('sanctum')->user()->email)
			->send(new SendAuthCode($code));
		return ApiResponse::success($code);
	}
}
