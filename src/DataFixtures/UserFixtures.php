<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setEmail('admin@admin.com')
            ->setPassword('admin')
            ->setRoles(["ROLE_USER", "ROLE_ADMIN"]);

        $manager->persist($user);

        $manager->flush();
    }
}
