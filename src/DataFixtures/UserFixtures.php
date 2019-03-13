<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $admin = new User();
        $admin->setEmail("admin@gmail.com");
        $admin->setUsername("AdminSupreme");
        $admin->setPassword($this->encoder->encodePassword($admin, "admin"));
        $admin->setIsActive(true);
        $admin->addRole("ROLE_ADMIN");
        $manager->persist($admin);

        $user = new User();
        $user->setEmail("user@gmail.com");
        $user->setUsername("User");
        $user->setPassword($this->encoder->encodePassword($user, "user"));
        $user->setIsActive(true);
        $user->addRole("ROLE_USER");
        $manager->persist($user);

        $manager->flush();
    }
}
