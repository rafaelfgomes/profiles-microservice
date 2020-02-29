<?php

namespace App\Traits;

use Illuminate\Http\Response;
use App\Http\Resources\Profile as ProfileResource;

trait ApiResponser
{
    /**
     *
     * Success Response
     *
     * @param string|array $data
     * @param int $code
     * @return Illuminate\Http\JsonResponse
     *
     *
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        $data = is_countable($data) ? ProfileResource::collection($data) : new ProfileResource($data);

        return response()->json([ 'data' => $data ], $code);
    }

    /**
     *
     * Success Response
     *
     * @param string|array $data
     * @param int $code
     * @return Illuminate\Http\JsonResponse
     *
     */
    public function errorResponse($message, $code)
    {

        return response()->json([ 'error' => $message, 'code' => $code ], $code);

    }
}
