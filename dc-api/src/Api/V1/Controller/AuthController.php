<?php

namespace DC\Api\V1\Controller;

use DC\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends BaseController
{
    /**
     * @Route("/auth", name="api_login")
     * @param Request $request
     */
    public function login(Request $request)
    {
        return $this->json(['login page']);
    }
}