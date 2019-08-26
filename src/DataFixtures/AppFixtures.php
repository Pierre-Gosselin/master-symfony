<?php

namespace App\DataFixtures;


use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ( $i = 0; $i<100; $i++)
        {
            $product = new Product();
            $product->setName('Iphone '.$i);
            $product->setDescription('Un smartphone'.$i);
            $product->setPrice(rand(500,1500));
            $manager->persist($product);
        }
        $manager->flush();
    }
}