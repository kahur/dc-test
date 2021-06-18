<?php

namespace DC\Tests\Unit\Service\Security\Authenticator;

use DC\Service\Security\Authenticator\Exception\AuthenticationFailedException;
use DC\Service\Security\Authenticator\TokenAuthenticator;
use DC\Service\Security\Token\TokenManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class TokenAuthenticatorTest extends TestCase
{
    public function testSuccessSupports()
    {
        $bag = $this->createMock(HeaderBag::class);
        $bag->expects($this->once())
            ->method('has')
            ->with('Auth')
            ->willReturn(true);

        $request = $this->createMock(Request::class);
        $request->headers = $bag;

        $tokenManager = $this->createMock(TokenManager::class);

        $authenticator = new TokenAuthenticator($tokenManager);

        $this->assertTrue($authenticator->supports($request));
    }

    public function testFailedSupports()
    {
        $bag = $this->createMock(HeaderBag::class);
        $bag->expects($this->once())
            ->method('has')
            ->with('Auth')
            ->willReturn(false);

        $request = $this->createMock(Request::class);
        $request->headers = $bag;

        $tokenManager = $this->createMock(TokenManager::class);

        $authenticator = new TokenAuthenticator($tokenManager);

        $this->assertFalse($authenticator->supports($request));
    }

    public function testAuthenticateSuccess()
    {
        $bag = $this->createMock(HeaderBag::class);

        $bag->expects($this->once())
            ->method('get')
            ->willReturn('token');

        $request = $this->createMock(Request::class);
        $request->headers = $bag;

        $tokenManager = $this->createMock(TokenManager::class);
        $tokenManager->expects($this->once())
            ->method('getTokenData')
            ->willReturn(['id' => 1]);

        $authenticator = new TokenAuthenticator($tokenManager);

        $this->assertInstanceOf(SelfValidatingPassport::class, $authenticator->authenticate($request));
    }

    public function testAuthenticateFailedNoToken()
    {
        $this->expectException(AuthenticationFailedException::class);
        $bag = $this->createMock(HeaderBag::class);

        $bag->expects($this->once())
            ->method('get')
            ->willReturn(null);

        $request = $this->createMock(Request::class);
        $request->headers = $bag;

        $tokenManager = $this->createMock(TokenManager::class);

        $authenticator = new TokenAuthenticator($tokenManager);
        $authenticator->authenticate($request);
    }

    public function testAuthenticateFailedInvalidData()
    {
        $this->expectException(AuthenticationFailedException::class);
        $bag = $this->createMock(HeaderBag::class);

        $bag->expects($this->once())
            ->method('get')
            ->willReturn('token');

        $request = $this->createMock(Request::class);
        $request->headers = $bag;

        $tokenManager = $this->createMock(TokenManager::class);
        $tokenManager->expects($this->once())
            ->method('getTokenData')
            ->willReturn([]);

        $authenticator = new TokenAuthenticator($tokenManager);
        $authenticator->authenticate($request);
    }
}