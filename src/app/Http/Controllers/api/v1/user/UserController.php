<?php

namespace App\Http\Controllers\api\v1\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function userNotifications()
    {
        return response()->json([
            \auth()->user()->unreadNotifications(),Response::HTTP_OK
        ]);
    }

    public function leaderboard()
    {
        return resolve(UserRepository::class)->leaderboards();
    }

}
