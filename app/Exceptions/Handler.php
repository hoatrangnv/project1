<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
        if(config('app.debug')=== false) {

            if ($exception instanceof AuthorizationException) {
                return $this->unauthorized($request, $exception);
            }

            if ($this->isHttpException($exception)) {
                switch ($exception->getStatusCode()) {
                    // not authorized
                    case '403':
                        return \Response::view('adminlte::errors.403', array(), 403);
                        break;
                    // not found    
                    case '404':
                        return \Response::view('adminlte::errors.404', array(), 404);
                        break;
                    case '401':
                        return \Response::view('adminlte::errors.401', array(), 404);
                        break;
                    // internal error
                    case '500':
                        return \Response::view('adminlte::errors.500', array(), 500);
                        break;
                    case '503':
                        $message = $exception->getMessage();
                        $retryAfter = $exception->retryAfter;
                        return \Response::view('adminlte::errors.503', array('message' => $message, 'retryAfter' => $retryAfter), 503);
                        break;
                    default:
                        return \Response::view('adminlte::errors.default', array(), 503);
                        break;
                }
            } else {
                return parent::render($request, $exception);
            }
        }
        
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Handle unauthorized response
     *
     * @param $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function unauthorized($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $exception->getMessage()], 403);
        }

        flash()->warning($exception->getMessage());
        return redirect()->route('home');
    }
}
