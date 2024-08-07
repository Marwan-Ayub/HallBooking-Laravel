<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // for error if happened in any pages 
    // public function render($request, Throwable $exception)
    // {
    //     // Check if the exception is an instance of Throwable (PHP exception)
    //     if ($exception instanceof Throwable) {
    //         // Redirect to the welcome page
    //         return redirect('/login')->with('error', 'An error occurred. Please try again later.');
    //     }

    //     // If the exception is not an instance of Throwable, proceed with default error handling
    //     return parent::render($request, $exception);
    // }

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
}
