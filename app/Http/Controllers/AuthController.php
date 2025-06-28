<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success('User created successfully', [
            'user' => UserResource::make($user),
            'token' => $token
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();
        if (!Hash::check($data['password'], $user->password)) {
            return ApiResponse::error('Validation error', [
                'password' => ['Invalid password']
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success('User logged in successfully', [
            'user' => UserResource::make($user),
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $token = $user->tokens()->delete();

        return ApiResponse::success('User logged out successfully', [
            'user' => UserResource::make($user),
            'token' => $token
        ], 200);
    }
}
