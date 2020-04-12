<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;


class Handler extends ExceptionHandler
{
    use ApiResponser;
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

    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        if($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("There is no instance of {$model} with the following id", 404);
        }
         if($exception instanceof AuthenticationException){
             return $this->unauthenticated($request, $exception);
         }   
         if($exception instanceof AuthorizationException){
            return $this->errorResponse("No tienes permisas para ejecutar esta accion", 403);
             
         }
         if($exception instanceof NotFoundHttpException){
             return $this->errorResponse('No se encontro la URL espesificada', 404);
         }
         if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('El metodo espesificado no es valido para esta Ent-Point', 405);
         }
         if($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
         }
        if($exception instanceof QueryException){
            // dd($exception);
            $code = $exception->errorInfo[1];
            if($code == 1451){
                return $this->errorresponse("No se puede eliminar de forma permanente el recurso, porque tiene una relacion", 409);
            }
            if($code == null){
                return $this->errorresponse("La base de datos esta deconectada", 500);

            }
            if($code == 1364){
                $message = strtolower(class_basename($exception->getMessage()));
                return $this->errorresponse($message, 400);    
            }
            if($code == 1452) {
                $message = strtolower(class_basename($exception->getMessage()));
                return $this->errorresponse($message, 400);
            }
        }
        if($exception instanceof ErrorException){
           return  dd($exception);
        }
        return parent::render($request, $exception);
    }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse("No autentido", 421);
            
    }
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {

        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);

    }
}

