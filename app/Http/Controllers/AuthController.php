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
		try {
			User::insert([
				'name' => $params['name'],
				'email' => $params['email'],
				'password' => Hash::make($params['password']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);
			return ApiResponse::success();
		} catch (\Throwable $th) {
			return ApiResponse::internalServerError();
		}
	}

	public function logout(Request $request)
	{
		try {
			$request->user()->tokens()->delete();
			return ApiResponse::success();
		} catch (\Throwable $th) {
			return ApiResponse::internalServerError();
		}
	}

	public function sendCode(Request $request)
	{
		$params = $request->all();
		$code = rand(1000, 9999);
		if (auth('sanctum')->user()->email == $params['email']) {
			Mail::to($params['email'])
				->send(new SendAuthCode($code));
			// TODO: fix storage code in somewhere...
			// $request->session()->put('code', $code);
			return ApiResponse::success([
				'email' => $params['email'],
				'code' => $code
			]);
		}
		return ApiResponse::internalServerError();
	}

	public function auth(Request $request)
	{
		$params = $request->all();
		$authCode = $request->session()->get('code');
		if ($authCode == $params['code']) {
			return ApiResponse::success();
		}
		return ApiResponse::internalServerError();
	}
}
