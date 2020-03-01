<?php

namespace App\Exceptions;

use Exception;
use ErrorException;
use ReflectionException;
use BadMethodCallException;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\Exception\FatalErrorException;

class Handler extends ExceptionHandler
{

    use ApiResponser;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        //return parent::render($request, $exception);

        if ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code];

            return $this->errorResponse($message, $code);
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = 'perfil';
            $message = "Não existe nenhum $model cadastrado com esse id";
            $code = Response::HTTP_NOT_FOUND;

            return $this->errorResponse($message, $code);
        }

        if ($exception instanceof AuthorizationException) {

            return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);

        }

        if ($exception instanceof AuthenticationException) {

            return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);

        }

        if ($exception instanceof ValidationException) {

            return $this->errorResponse($exception->validator->errors()->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);

        }

        if ($exception instanceof ReflectionException ||
            $exception instanceof QueryException ||
            $exception instanceof BadMethodCallException ||
            $exception instanceof FatalErrorException ||
            $exception instanceof ErrorException) {

            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        if (env('MICROSERVICE_DEBUG', false)) {
            return parent::render($request, $exception);
        }

        $this->errorResponse('Erro inesperado', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
