<?php

namespace DC\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController extends BaseController
{
    public function error()
    {
        return new Response('<h1>Not found</h1>', 404);
    }
}