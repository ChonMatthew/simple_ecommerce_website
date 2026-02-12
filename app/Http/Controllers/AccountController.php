<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    /**
     * Display the authenticated user's account page.
     */
    public function show(): Response
    {
        $user = Auth::user();

        return Inertia::render('Account', [
            'user' => $user,
        ]);
    }
}
