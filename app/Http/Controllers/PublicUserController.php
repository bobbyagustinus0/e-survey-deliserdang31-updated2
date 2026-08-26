<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicUserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->orderBy('name')
            ->get();

        return view('public.users', compact('users'));
    }

    public function show(User $user)
    {
        return view('public.user-detail', compact('user'));
    }
}