<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\UnauthorizedException;
 use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ApiResponse;
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

         $this->renderable(function (UnauthorizedException $ex, $request) {
            Log::error($ex);
            return $this->sendError(
                $ex->getMessage(),
                [],
                $ex->getStatusCode());
        });

        $this->renderable(function (Exception $ex, $request) {
            Log::error($ex);
            
            return $this->sendError(
                App::environment(['production'])? 'Something Went Wrong!' : $ex->getMessage(),
                [],
                500);
        });
    }  
}
