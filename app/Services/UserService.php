<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserService
{
    public function getCurrentUser(Request $request): User
    {
        $userId = Session::get('user_id');

        if ($userId) {
            $user = User::find($userId);
            if ($user !== null) {
                return $user;
            } else {
                return $this->createGuestUser($request);
            }
        }

        return $this->createGuestUser($request);
    }

    private function createGuestUser(Request $request): User
    {
        $ipAddress = $request->ip();
        $user = new User();
        $user->ip_address = $ipAddress;
        $user->session_id = Session::getId();
        $user->name = 'Guest ' . uniqid();

        $user->save();

        Session::put('user_id', $user->id);
        return $user;
    }
}
