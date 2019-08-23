<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function create()
    {

        $product = new Product();
        $product->setName('Iphone X')
                ->setDescription('Un téléphone')
                ->setPrice(1500);
        
        // On récupère le manager Doctrine pour gérer la BDD
        $entityManager = $this->getDoctrine()->getManager();

        // On met en attente l'objet dans Doctrine
        $entityManager->persist($product);

        // Exécute la requête (INSERT...)
        $entityManager->flush();

        return $this->render('product/create.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
