<?php

namespace DC\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseController
{
    public function index()
    {
        return new Response('<h1>Not found</h1>', 404);
    }
}