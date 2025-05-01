<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\AccessResource;
use App\Models\Information;
use App\Models\User;
use Illuminate\Http\Request;

class AccessController extends Controller
{
	public function login(Request $request)
	{
		$params = $request->all();
		$email = $params['email'];
		$password = $params['password'];
		$user = User::where('email', $email)
			->where('password', $password)
			->first();
		if (!is_null($user)) {
			return ApiResponse::success(new AccessResource($user));
		} else {
			return ApiResponse::dataNotfound();
		}
	}

	public function register(Request $request)
	{
		$params = $request->all();
		$email = $params['email'];
		$password = $params['password'];
		$check = 0;
		foreach (User::get() as $user) {
			if ($user->email == $email) {
				return ApiResponse::internalServerError();
			} else {
				$check += 1;
			}
		}
		if ($check > 0) {
			User::insert([
				'email' => $email,
				'password' => $password,
				'role' => 3,
				'status' => 1,
				'information_id' => Information::create(
					[
						'name' => 'Customer-' . count(Information::get()),
					]
				)->id,
				'score' => 0,
				'total_score' => 0
			]);
			return ApiResponse::success();
		}
	}
}
