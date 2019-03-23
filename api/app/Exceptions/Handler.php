<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class Handler extends ExceptionHandler
{
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson()) {
            $response = [
                'message' => (string) $exception->getMessage(),
                'status' => 400,
                'details' => null,
            ];

            if ($exception instanceof ValidationException) {
                $response['message'] = $exception->getMessage();
                $response['details'] = $exception->errors();
                $response['status'] = Response::HTTP_BAD_REQUEST;
            } else if ($exception instanceof HttpException) {
                $response['message'] = Response::$statusTexts[$exception->getStatusCode()];
                $response['status'] = $exception->getStatusCode();
            } else if ($exception instanceof ModelNotFoundException) {
                $response['message'] = Response::$statusTexts[Response::HTTP_NOT_FOUND];
                $response['status'] = Response::HTTP_NOT_FOUND;
            } else if ($exception instanceof Exception) {
                $response['message'] = Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];
                $response['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            // TODO: Add any other exception before Exception  to be return a more specific response error.

            if (env('APP_DEBUG')) {
                $response['debug'] = [
                    'exception' => get_class($exception),
                    'trace' => $exception->getTraceAsString()
                ];
            }

            return response()->json(['error' => $response], $response['status']);

        }

        return parent::render($request, $exception);
    }
}
