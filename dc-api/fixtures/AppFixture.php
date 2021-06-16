<?php

namespace DC\Fixtures;

use DC\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixture extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager)
    {
        // create default user

        $user = new User();
        $user->setName('Jonhy Bravo');
        $user->setEmail('jonhy@bravo.tld');
        $user->setPassword($this->passwordHasher->hashPassword($user,'1234'));

        $manager->persist($user);
        $manager->flush();
    }
}