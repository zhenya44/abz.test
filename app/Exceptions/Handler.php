<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $code = "";

        if(method_exists($exception, 'getStatusCode'))
        {
            $code = $exception->getStatusCode();
        }

        if(property_exists($exception, 'status'))
        {
            $code = $exception->status;
        }

        if($code == "422")
        {
            $data = [
                'success' => false,
                'message' => $exception->getMessage()
            ];

            if(property_exists($exception, 'validator'))
            {
                $data = [
                    'success' => false,
                    'message' => "Validation failed",//"Validation failed","Positions not found"
                    'fails' => $exception->validator->customMessages
                        ? $exception->validator->customMessages
                        : $exception->validator->messages()->getMessages()
                ];
            }

            return \response($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if($code == "404")
        {
            return \response(
                [
                    'success' => false ,
                    'message' => "Page not found"
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        if($code == "401")
        {
            return \response(
                [
                    'success' => false ,
                    'message' => $exception->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        if($code == "400")
        {
            return \response(
                [
                    'success' => false,
                    'message' => "Validation failed",
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return \response(
            [
                'success' => false,
                'message' => $exception->getMessage()
            ],
            $exception->getCode() ? $exception->getCode() : '400'
        );
    }
}
