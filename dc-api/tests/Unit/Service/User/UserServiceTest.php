<?php

namespace DC\Tests\Unit\Service\User;

use DC\Entity\User;
use DC\Repository\UserRepository;
use DC\Service\User\Exception\UserNotFoundException;
use DC\Service\User\UserService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserServiceTest extends TestCase
{
    public function testAuthenticate()
    {
        $user = new User();
        $user->setEmail('test');
        $user->setName('test');

        $hash = $this->getMockBuilder(UserPasswordHasherInterface::class)->addMethods(['isPasswordValid'])->getMock();
        $hash->expects($this->once())
            ->method('isPasswordValid')
            ->with($user, '1234')
            ->willReturn(true);

        $repository = $this->createMock(UserRepository::class);
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'test'])
            ->willReturn($user);

        $userService = new UserService($hash,$repository);

        $this->assertEquals($user, $userService->authenticateUser('test', 1234));
    }

    public function testAuthenticateUserNotFound()
    {
        $this->expectException(UserNotFoundException::class);
        $user = new User();
        $user->setEmail('test');
        $user->setName('test');

        $hash = $this->getMockBuilder(UserPasswordHasherInterface::class)->addMethods(['isPasswordValid'])->getMock();

        $repository = $this->createMock(UserRepository::class);
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'test'])
            ->willReturn(null);

        $userService = new UserService($hash,$repository);

        $userService->authenticateUser('test', 1234);
    }

    public function testAuthenticateInvalidPassword()
    {
        $this->expectException(UserNotFoundException::class);
        $user = new User();
        $user->setEmail('test');
        $user->setName('test');

        $hash = $this->getMockBuilder(UserPasswordHasherInterface::class)->addMethods(['isPasswordValid'])->getMock();
        $hash->expects($this->once())
            ->method('isPasswordValid')
            ->with($user, '1234')
            ->willReturn(false);

        $repository = $this->createMock(UserRepository::class);
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'test'])
            ->willReturn($user);

        $userService = new UserService($hash,$repository);

        $userService->authenticateUser('test', 1234);
    }
}