<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('surveyResponses')
            ->orderBy('name')
            ->get();

        return view('public.users', compact('users'));
    }

    public function show(User $user)
    {
        $user->load([
            'surveyResponses.template',
            'surveyResponses.answers.question'
        ]);

        return view('public.user-detail', compact('user'));
    }
}