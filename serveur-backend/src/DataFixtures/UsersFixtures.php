<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use League\FactoryMuffin\Faker\Facade as Faker;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // $faker = Factory::create('fr_FR');
        // $faker->addProvider(new)

        $manager->flush();
    }
}
