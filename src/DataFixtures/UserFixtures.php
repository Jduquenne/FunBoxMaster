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
        $admin->setUsername("Admin");
        $admin->setImgProfil("bc8a88280e139feef04d2daac2d7f041.jpeg");
        $admin->setPassword($this->encoder->encodePassword($admin, "admin"));
        $admin->setIsActive(true);
        $admin->addRole("ROLE_ADMIN");
        $manager->persist($admin);

        $user = new User();
        $user->setEmail("user@gmail.com");
        $user->setUsername("User");
        $user->setImgProfil("0b671725f275b6fcf1559c95897c7ef3.jpeg");
        $user->setPassword($this->encoder->encodePassword($user, "user"));
        $user->setIsActive(true);
        $user->addRole("ROLE_USER");
        $manager->persist($user);

        $manager->flush();
    }
}
