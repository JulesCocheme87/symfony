<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoadUserData extends Fixture implements FixtureGroupInterface
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'username' => 'lucas',
                'password' => 'adminpass',
                'apitoken' => '12345',
                'roles' => ['ROLE_ADMIN']
            ]
        ];

        foreach ($users as $user) {
            $objUser = new User();
            $objUser->setUsername($user['username']);
            $objUser->setPassword($this->passwordHasher->hashPassword($objUser, $user['password']));
            $objUser->setApiToken($user['apitoken']);
            $objUser->setRoles($user['roles']);

            $manager->persist($objUser);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group4'];
    }
}
