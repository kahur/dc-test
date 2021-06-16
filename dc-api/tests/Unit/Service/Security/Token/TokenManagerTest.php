<?php

namespace DC\Tests\Unit\Service\Security\Token;

use DC\Service\Security\Token\Adapter\Exception\ExpiredTokenException;
use DC\Service\Security\Token\Interfaces\AdapterInterface;
use DC\Service\Security\Token\TokenManager;
use PHPUnit\Framework\TestCase;

class TokenManagerTest extends TestCase
{
    public function testGenerateToken()
    {
        $mock = $this->createMock(AdapterInterface::class);
        $mock->expects($this->once())
            ->method('encode')
            ->willReturn('abc');

        $manager = new TokenManager($mock);
        $result = $manager->generateToken(['test']);

        $this->assertEquals('abc', $result);
    }

    public function testGetTokenData()
    {
        $mock = $this->createMock(AdapterInterface::class);
        $mock->expects($this->once())
            ->method('decode')
            ->willReturn(['data']);

        $manager = new TokenManager($mock);
        $result = $manager->getTokenData('token');

        $this->assertEquals(['data'], $result);
    }

    public function testSuccessValidateToken()
    {
        $mock = $this->createMock(AdapterInterface::class);
        $mock->expects($this->once())
            ->method('validate');


        $manager = new TokenManager($mock);
        $result = $manager->isTokenValid('token');

        $this->assertTrue($result);
    }

    public function testFailedValidateToken()
    {
        $mock = $this->createMock(AdapterInterface::class);
        $mock->expects($this->once())
            ->method('validate')
            ->willThrowException(new ExpiredTokenException('test'));


        $manager = new TokenManager($mock);
        $result = $manager->isTokenValid('token');

        $this->assertFalse($result);
    }
}