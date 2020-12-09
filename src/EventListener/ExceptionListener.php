<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpException) {
            $response = new JsonResponse();
            $response->setContent(json_encode(['message' => $exception->getMessage(), 'data' => []], JSON_UNESCAPED_UNICODE));
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
            $event->setResponse($response);

        }
    }
}
