<?php

namespace App\Http\Controllers;
use App\Http\Requests\PasswordCreateRequest;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PasswordResetController extends Controller {

	// create token for password reset
	public function create(PasswordCreateRequest $request) {
		$user = User::where('email', $request->email)->first();
		$passwordReset = PasswordReset::updateOrCreate(
			['email' => $user->email],
			[
				'email' => $user->email,
				'token' => Str::random(60),
			]
		);

		if ($user && $passwordReset) {
			$user->notify(
				new PasswordResetRequest($passwordReset->token)
			);
		}

		return response()->json([
			'message' => 'We have e-mailed your password reset link!',
		]);
	}

	// find the token password reset
	public function find($token) {
		$passwordReset = PasswordReset::where('token', $token)
			->first();

		if (!$passwordReset) {
			return response()->json([
				'message' => 'This password reset token is invalid.',
			], 404);
		}

		if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
			$passwordReset->delete();
			return response()->json([
				'message' => 'This password reset token is expired.',
			], 404);
		}
		return response()->json($passwordReset);
	}

	// reset password
	public function reset(Request $request) {
		$request->validate([
			'email' => 'required|string|email',
			'password' => 'required|string|min:6',
			'token' => 'required|string',
		]);

        $passwordReset = PasswordReset::where('token', $request->token)->where('email', $request->email)->first();

		if (!$passwordReset) {
			return response()->json([
				'message' => 'This password reset token is invalid.',
			], 404);
		}

		$user = User::where('email', $passwordReset->email)->first();
		if (!$user) {
			return response()->json([
				'message' => 'We cant find a user with that e-mail address.',
			], 404);
		}

		$user->password = bcrypt($request->password);
		$user->save();
		$passwordReset->delete();
		$user->notify(new PasswordResetSuccess($passwordReset));
		return response()->json($user);
	}
}
