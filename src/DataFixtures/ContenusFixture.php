<?php

namespace App\DataFixtures;

use App\Entity\Contenus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Faker\Factory;

class ContenusFixture extends Fixture
{
    public function load(ObjectManager $manager )
    {
        $sourceDir = 'public/FakerImages';
        $targetDir = 'public/ImgUpload';

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $contenus = new Contenus();
            $contenus
                ->setTitre($faker->words(3, true))
                ->setAuteur($faker->userName)
                ->setDate($faker->dateTime($max = 'now'))
                ->setFile($faker->file($sourceDir, $targetDir, false));

            $manager->persist($contenus);
        }
        $manager->flush();
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
