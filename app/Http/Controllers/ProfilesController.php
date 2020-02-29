<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Profile as UserProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $this->validate($request, UserProfile::validationRules());
        $fields = UserProfile::setFields($request, $request->method());
        $profile = UserProfile::create($fields);
        return $this->successResponse($profile, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, UserProfile::validationRules());

        $profile = UserProfile::findOrFail($id);
        $request['uuid'] = $profile->uuid;
        $fields = UserProfile::setFields($request, $request->method());

        $profile->fill($fields);

        if ($profile->isClean()) {
            return $this->errorResponse('Nenhuma informação foi atualizada', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $profile->save();

        return $this->successResponse($profile);
    }

    public function delete($id)
    {
        $handler = new Handler;
        $profile = UserProfile::withTrashed()->find($id);

        if (is_null($profile)) {
            $notFound = new ModelNotFoundException;
            $notFound->setModel(UserProfile::class, $id);
            return $handler->render([], $notFound);
        } else {
            if (!is_null($profile->deleted_at)) {
                return $this->errorResponse('Este perfil já está inativo', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $profile->delete();

        return $this->successResponse($profile);
    }

    public function activate($id)
    {
        $handler = new Handler;
        $profile = UserProfile::withTrashed()->find($id);

        if (is_null($profile)) {
            $notFound = new ModelNotFoundException;
            $notFound->setModel(UserProfile::class, $id);
            return $handler->render([], $notFound);
        } else {
            if (is_null($profile->deleted_at)) {
                return $this->errorResponse('Este perfil já está ativo', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $profile->restore();

        return $this->successResponse($profile);
    }
}
