<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // créer les utilisateurs
        $users = []; // Le tableau va nous aider à stocker les instances des user
        for ( $i = 0; $i<10; $i++)
        {
            $user = new User();
            $user->setUsername('Username'.$i);
            $manager->persist($user);
            $users[] = $user;
        }

        // Créer les catégories
        $categories = []; // le tableau va nous aider à stocker les instances des catégories
        for ( $i = 0; $i<10; $i++)
        {
            $category = new Category();
            $category->setName('Categorie'.$i);
            $manager->persist($category);
            $categories[] = $category; //On met l'instance de coté
        }

        // Créer les tags

        for ( $i = 0; $i < 10; $i++)
        {
            $tag = new Tag();
            $tag->setName('Tag'.$i);
            $manager->persist($tag);
        }
        // Créer les produits
        for ( $i = 0; $i<50; $i++)
        {
            $product = new Product();
            $product->setName('iPhone '.$i);
            $product->setDescription('Un smartphone '.$i);
            $product->setPrice(rand(500,1500));
            // On associe le produit à une instance de user ($user correspond au dernier user créé)
            $product->setCategory($categories[rand(0,9)]);
            $product->setUser($users[rand(0,9)]);
            $manager->persist($product);
        }
        $manager->flush();
    }
}