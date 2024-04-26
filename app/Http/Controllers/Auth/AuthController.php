<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use App\Services\Auth\AuthServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * This method creates a new user record in the database with the provided
     * first name, last name, email, and password. It generates a unique username
     * based on the first name and last name. The user is saved in a transaction
     * to ensure data consistency. If an error occurs during registration, the
     * transaction is rolled back and the error is reported.
     *
     * @param RegisterUserRequest $request The request containing user registration data.
     * @param AuthServices $authServices The authentication services instance.
     * @return Response A Response represents an HTTP response indicating the result of the registration.
     */
    public function register(RegisterUserRequest $request, AuthServices $authServices)
    {
        try {
            DB::beginTransaction();
            User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'username' => $authServices->generateUniqueUsername($request->input('first_name'), $request->input('last_name')),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
            DB::commit();
            return response()->json([
                'message' => 'User registered successfully'
            ], Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json([
                'message' => 'User registered failed',
                'error' => $exception->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Attempt to log in a user using the provided credentials.
     *
     * @param LoginUserRequest $request
     * @return Response
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('username_or_email', 'password');

        $field = filter_var($credentials['username_or_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials[$field] = $credentials['username_or_email'];
        unset($credentials['username_or_email']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->accessToken;

            return response()->json([
                'message' => 'Successfully logged in',
                'token' => $token
            ], 201);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
