<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Mission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MissionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 100; $i++) {
            $mission = new Mission();
            $mission
                ->setName($faker->name)
                ->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2))
                ->setLink($faker->url)
                ->setFilename($faker->imageUrl(290, 180,'business', true ))
                ->setDate($faker->dateTimeAD($max = 'now', $timezone = null));
            $manager->persist($mission);
        }

        for($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category
                ->setName($faker->company);
            $manager->persist($category);
        }


        $manager->flush();
    }
}
