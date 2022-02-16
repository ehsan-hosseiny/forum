<?php

namespace App\Http\Controllers\api\v1\user;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function userNotifications()
    {
        return response()->json([
            \auth()->user()->unreadNotifications(),Response::HTTP_OK
        ]);
    }

}
