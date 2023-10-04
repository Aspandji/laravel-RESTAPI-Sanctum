<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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

    public function render($request, Throwable $e)
    {
        if ($request->is('api*')) {
            // Error Validasi
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'status' => 'Error',
                    'errors' => $e->errors()
                ], 422);
            }
            // Error Authorization 
            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                return response()->json([
                    'status' => 'Error',
                    'errors' => 'Anda Tidak Memiliki Hak Akses'
                ], 403);
            }
            // Error data Not Found
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json([
                    'status' => 'Error',
                    'errors' => 'Data Not Found'
                ], 404);
            }
            // Url Tidak Valid
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->json([
                    'status' => 'Error',
                    'errors' => 'URL Invalid'
                ], 404);
            }
            // Token Tidak Valid
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json([
                    'status' => 'Error',
                    'errors' => $e->getMessage()
                ], 401);
            }

            // other error
            return response([
                'status' => 'Error',
                'errors' => 'Something Wrong!!..'
            ], 500);
        }
        parent::render($request, $e);
    }
}
