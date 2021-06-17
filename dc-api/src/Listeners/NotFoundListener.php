<?php

namespace DC\Listeners;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();


        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof NotFoundHttpException) {
            $response = new RedirectResponse('/404');
            // sends the modified response object to the event
            $event->setResponse($response);
        }
    }
}