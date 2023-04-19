<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;


use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Validation\ValidationException){
            return response()->json(['Error' => $exception->getMessage()])->setStatusCode($exception->getCode());
        }
        if($exception instanceof  \Illuminate\Validation\UnauthorizedException){
            return response()->json(['Error' => $exception->getMessage()])->setStatusCode($exception->getCode());
        }
        if($exception instanceof ClientException){
            return response()->json(['Error' => $exception->getMessage()])->setStatusCode($exception->getCode());
        }
        if($exception instanceof  GuzzleClientException){
            $response = $exception->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return response()->json(
                [   
                'Error' => 'ExceptionMessage: '.$exception->getMessage().
                    ' ReasonPhrase: '.$response->getReasonPhrase().
                    ' ResponseBody: '.$responseBodyAsString,
                ]
            )->setStatusCode($exception->getCode());
        }
        
        if(env('APP_DEBUG')){
            dd($exception);
        }
    }

}
