<?php

namespace DC\Service\Security\Token;

use DC\Service\Security\Token\Adapter\Exception\ExpiredTokenException;
use DC\Service\Security\Token\Interfaces\AdapterInterface;

class TokenManager
{
    /**
     * @var AdapterInterface
     */
    private $tokenAdapter;

    public function __construct(AdapterInterface $tokenAdapter)
    {
        $this->tokenAdapter = $tokenAdapter;
    }

    /**
     * @param array $data
     * @return string
     */
    public function generateToken(array $data): string
    {
        $token = $this->tokenAdapter->encode($data);

        return $token;
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getTokenData(string $token)
    {
        return $this->tokenAdapter->decode($token);
    }

    /**
     * @param $token
     * @return bool
     */
    public function isTokenValid($token): bool
    {
        try {
            $this->tokenAdapter->validate($token);

            return true;
        } catch (ExpiredTokenException $e) {
            return false;
        }
    }
}