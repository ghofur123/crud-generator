<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthControllerRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(AuthControllerRequest $request)
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function login(UserRequest $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Email Atau Password Salah'
                    ], 201);
            }

            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',
                ]);
        } catch (\Exception $e) {
            return response()
                ->json(['message' => 'Terjadi kesalahan dalam proses login'], 500);
        }
    }
    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
