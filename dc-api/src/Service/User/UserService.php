<?php

namespace DC\Service\User;

use DC\Repository\UserRepository;
use DC\Service\User\Exception\UserNotFoundException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

/**
 * This service is simple but it's here for demonstration :)
 *
 * Class UserService
 * @package DC\Service
 */
class UserService
{
    /**
     * @var UserPasswordHasherInterface
     */
    protected $passwordHasher;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserPasswordHasherInterface $passwordHasher
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $email
     * @param string $password
     * @return \DC\Entity\User
     * @throws UserNotFoundException
     */
    public function authenticateUser(string $email, string $password)
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new UserNotFoundException('User not found');
        }

        return $user;
    }

}