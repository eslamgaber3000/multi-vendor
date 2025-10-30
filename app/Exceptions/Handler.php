<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;

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
protected $dontReport = [
// QueryException::class, // hide QueryException from being reported

];
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (QueryException $e) {
            if ($e->getCode() === '23000') {
               
                Log::channel('stack')->critical('Database error: You can not delete or update a parent row: a foreign key constraint fails.', [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'sql' => $e->getSql(),
                    'bindings' => $e->getBindings(),
                ]);
                return false;

            }else {
                return true;
            }
            
        });

        $this->renderable(function (QueryException $e, $request) {


            if ($e->getCode() === '23000') {

               $message = ' You can not delete or update a parent row: a foreign key constraint fails.';
            }else{
                $message = 'Database error: ' . $e->getMessage();
            }

            if($request->expectsJson()){
                return response()->json([
                    'error' => $message
                ], 400);
            }
            return redirect()->back()->withInput()->with('info', $message);

        });
    }
    
}
