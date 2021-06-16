<?php

namespace DC\Tests\Unit\Service\Security\Token\Adapter;

use DC\Service\Security\Token\Adapter\Exception\ExpiredTokenException;
use DC\Service\Security\Token\Adapter\Exception\MissingDataException;
use DC\Service\Security\Token\Adapter\Exception\UnsupportedAlgorithmException;
use DC\Service\Security\Token\Adapter\Exception\UnsupportedDataFormatException;
use DC\Service\Security\Token\Adapter\JwtAdapter;
use Firebase\JWT\JWT;
use PHPUnit\Framework\TestCase;

class JwtAdapterTest extends TestCase
{
    // let's try to break it down here

    public function testUnsuportedAlgorithm()
    {
        $this->expectException(UnsupportedAlgorithmException::class);
        $jwt = new JwtAdapter('test', 'test');
        $jwt->encode(['data'], 'non-existent-algorithm');
    }

    public function testMissingDataFields()
    {
        $this->expectException(MissingDataException::class);
        $jwt = new JwtAdapter('test', 'test');
        $jwt->encode(['data']);
    }

    public function testUnsuportedData()
    {
        $this->expectException(UnsupportedDataFormatException::class);
        $jwt = new JwtAdapter('test', 'test');
        $jwt->encode(new \stdClass());
    }

    public function testExpiredToken()
    {
        $this->expectException(ExpiredTokenException::class);
        $jwt = new JwtAdapter('test', 'test');
        $t = $jwt->encode(['expiration' => 0]);

        // wait a bit to make sure token expires
        usleep(100);
        $jwt->decode($t);

    }

    // successfull scenarios
    public function testEncodeToken()
    {
        $exp = new \DateTime();
        $exp->add(new \DateInterval('PT1H'));
        $token = JWT::encode([
            'iss' => 'test',
            'exp' => $exp->getTimestamp(),
            'iat' => (new \DateTime())->getTimestamp()
        ], 'test');

        $jwt = new JwtAdapter('test', 'test');
        $t = $jwt->encode(['expiration' => 1]);

        $this->assertEquals($token, $t);
    }

    public function testDecodeToken()
    {
        $exp = new \DateTime();
        $exp->add(new \DateInterval('PT1H'));
        $payload = [
            'iss' => 'test',
            'exp' => $exp->getTimestamp(),
            'iat' => (new \DateTime())->getTimestamp(),
            'data' => 'test'
        ];
        $token = JWT::encode([
            $payload
        ], 'test');

        $jwt = new JwtAdapter('test', 'test');
        $result = $jwt->decode($token, 'test');

        $this->assertEquals($payload, $result);
    }

    public function testValidateToken()
    {
        $exp = new \DateTime();
        $exp->add(new \DateInterval('PT1H'));
        $payload = [
            'iss' => 'test',
            'exp' => $exp->getTimestamp(),
            'iat' => (new \DateTime())->getTimestamp(),
            'data' => 'test'
        ];
        $token = JWT::encode([
            $payload
        ], 'test');

        $jwt = new JwtAdapter('test', 'test');
        $jwt->validate($token, 'test');

        $this->assertTrue(true);
    }
}