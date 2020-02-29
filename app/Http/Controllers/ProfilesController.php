<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Profile as UserProfile;

class ProfilesController extends Controller
{

    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show($id = null)
    {
        $profile = (is_null($id)) ? UserProfile::all() : UserProfile::findOrFail($id);

        return $this->successResponse($profile);
    }

    public function store(Request $request)
    {
        $fields = UserProfile::setFields($request, $request->method());

        try {
            $profile = UserProfile::create($fields);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->successResponse($profile);

    }

    public function update(Request $request, $id)
    {

        $fields = UserProfile::setFields($request, $request->method());

        try {
            $profile = tap(UserProfile::findOrFail($id))->update($fields);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->successResponse($profile);
    }

    public function delete($id)
    {
        try {
            $profile = tap(UserProfile::findOrFail($id))->delete();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->successResponse($profile);
    }
}
