<?php

namespace App\Exceptions;

use App\Traits\HasJsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use HasJsonResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json([
                'message' => 'Not Found!'
            ], Response::HTTP_NOT_FOUND);
        }

        $exception = $this->prepareException($exception);

        if ($response = $this->responsableException($exception, $request)) {
            return $response;
        }

        if ($exception instanceof HttpException) {
            return $this->convertHttpExceptionToJson($exception);
        }

        return parent::render($request, $exception);
    }
    
    /**
     * Responsable exception
     *
     * @param   $exception
     * @param  \Throwable  $exception
     * @return null|\Illuminate\Http\JsonResponse
     */
    protected function responsableException(Throwable $exception): ?JsonResponse
    {
        if ($exception instanceof HttpResponseException) {
            return $this->wrapJsonResponse($exception->getResponse(), 'An error occurred.');
        }

        return null;
    }

    /**
     * Convert HTTP exception to JSON
     *
     * @param   $exception
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException $exception
     * @return null|\Illuminate\Http\JsonResponse
     */
    protected function convertHttpExceptionToJson(HttpException $exception): JsonResponse
    {
        $statusCode = $exception->getStatusCode();
        $message = $exception->getMessage() ?: Response::$statusTexts[$statusCode];
        $headers = $exception->getHeaders();
        $data = null;

        return $this->jsonResponse($statusCode, $message, $data, $headers);
    }
}
