<?php

namespace DC\Api\V1\Controller;

use DC\Service\Security\Token\TokenManager;
use DC\Service\User\Exception\UserNotFoundException;
use DC\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends ApiBaseController
{
    /**
     * @Route("/auth", name="api_login", methods={"POST"})
     * @param Request $request
     */
    public function login(Request $request, UserService $userService, TokenManager $tokenManager)
    {
        if (!$request->get('email') || !$request->get('password')) {
            return $this->response('Invalid fields', self::STATUS_ERROR);
        }

        $email = $request->get('email');
        $password = $request->get('password');

        try {
            $user = $userService->authenticateUser($email, $password);
            $token = $tokenManager->generateToken(['expiration' => 72, 'id' => $user->getUserIdentifier()]);

            return $this->response([
                'token' => $token,
                'name' => $user->getUsername()
            ], self::STATUS_OK);

        } catch (UserNotFoundException $e) {
            return $this->response($e->getMessage(), self::STATUS_ERROR);
        }
    }
}