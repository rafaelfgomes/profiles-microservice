<?php

namespace App\Http\Controllers;

use App\Profile as UserProfile;
use App\Http\Resources\Profile as ProfileResource;

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
        return response()->json(ProfileResource::collection(UserProfile::all()));
    }

    public function show($id)
    {
        $profile = UserProfile::findOrFail($id);

        return response()->json(new ProfileResource($profile));
    }
}
