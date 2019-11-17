<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $property = new Property();
            $property->setTitle($faker->words(4, true))
                ->setDescription($faker->sentence(10, true))
                ->setSurface($faker->numberBetween(15, 500))
                ->setBedrooms($faker->numberBetween(1, 9))
                ->setRooms($faker->numberBetween(2, 10))
                ->setFloor($faker->numberBetween(0, 40))
                ->setPrice($faker->numberBetween(10000, 100000000))
                ->setHeat($faker->numberBetween(0, 2))
                ->setAdress($faker->address)
                ->setCity($faker->city)
                ->setPostalCode($faker->postcode)
                ->setSold(false);
            $manager->persist($property);
        }
        $manager->flush();
    }
}
