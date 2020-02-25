<?php

namespace App\Http\Controllers;

use App\Profile as UserProfile;

class ProfilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return response()->json(UserProfile::all());
    }
}
