<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // ✅ Handle Method Not Allowed error
        if ($exception instanceof MethodNotAllowedHttpException)
        {
            // If user tried to access /login with GET
            if ($request->is('login'))
            {
                return response()->view('errors.custom', [
                    'title' => 'Invalid Request Method',
                    'message' => 'You cannot access the login page directly. Please use the login form to sign in.'
                ], 405);
            }

            // For any other route with the same error
            return response()->view('errors.custom', [
                'title' => 'Request Error',
                'message' => 'The request method is not allowed for this route.',
                'exception' => $exception,
            ], 405);
        }

        return parent::render($request, $exception);
    }
}
