<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register New User
     * @method POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate Form Inputs
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        // Insert User Into Database
       $user = resolve(UserRepository::class)->create($request);

        $default_super_admin_mail = config('permission.default_super_admin_email');

        $user->email == $default_super_admin_mail ? $user->assignRole('Super Admin') : $user->assignRole('User');

        return response()->json(['message' => 'user created successfully'], Response::HTTP_CREATED);
    }

    /**
     * Login User
     * @method GET
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        // Validate Form Inputs
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check User Credentials For Login
        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(Auth::user(), Response::HTTP_OK);
        }

        throw ValidationException::withMessages([
            'email' => 'incorrect credentials.'
        ]);

    }

    public function user()
    {
        $data =[
            Auth::user(),
            'notifications' => Auth::user()->unreadNotifications()
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'logged out successfully']);
    }

}
