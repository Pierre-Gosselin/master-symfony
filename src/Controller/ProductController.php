<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function create(Request $request)
    {

        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);

        $form->handleRequest($request);

        // Quand le formulaire envoyé est valide
        if ($form->isSubmitted() && $form->isValid())
        {       
            // On récupère le manager Doctrine pour gérer la BDD
            $entityManager = $this->getDoctrine()->getManager();

            // On met en attente l'objet dans Doctrine
            $entityManager->persist($product);

            // Exécute la requête (INSERT...)
            $entityManager->flush();

            return $this->redirectToRoute('product_create');
        }


        return $this->render('product/create.html.twig', ['form' => $form->createView(),]);
    }


    /**
     * @Route("/product/demo",name="demo")
     */
    public function demo()
    {
        // Récupéer le repository de l'entité Product
        $productRepository = $this->getDoctrine()->getRepository(Product::class);

        // Récupérer tous les produits
        $products = $productRepository->findAll();

        // Récupérer le produit avec l'id 2
        $productId = $productRepository->find(2);

        // Récupérer le produit qui se nomme iPhone X
        // $productRepository->findOneByName('iPhone X');
        $productName = $productRepository->findOneBy(['name' => 'iPhone X']);

        // Récupérer tous les produits qui coûte 1500 euros exactement
        $productsPrice = $productRepository->findByPrice(1500);

        return $this->render('product/demo.html.twig',[
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/delete/{id}",name="delete")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        $entityManager->remove($product);
        
        // On exécute la requête (DELETE...)
        $entityManager->flush();

        return $this->render('product/demo.html.twig',[
            'products' => $product,
        ]);
    }

    /**
     * @Route("/product/update/{id}",name="update")
     */
    public function update($id,Request $request)
    {

        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        $form = $this->createForm(ProductType::class,$product);

        $form->handleRequest($request);

        if ($product != null)
        {
            $name = $product->getName();
            $description = $product->getDescription();
            $price = $product->getPrice();

            // Quand le formulaire envoyé est valide
            if ($form->isSubmitted() && $form->isValid())
            {       
                // On récupère le manager Doctrine pour gérer la BDD
                $entityManager = $this->getDoctrine()->getManager();

                // On edit l'objet
                $product->setName($name);
                $product->setDescription($description);
                $product->setPrice($price);

                // Exécute la requête (INSERT...)
                $entityManager->flush();

                return $this->redirectToRoute('list');
            }
        }
        else
        {
            return $this->redirectToRoute('list');
        }


        return $this->render('product/create.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/{id}",name="product_show")
     */

    public function show(Product $product)
    {
        /*$product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        
        // Si le produit n'existe pas, on renvoi une 404
        if (!$product)
        {
            throw $this->createNotFoundException();
        } */

        return $this->render('product/show.html.twig',[
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product",name="list")
     */
    public function list()
    {
        // Récupéer le repository de l'entité Product
        $productRepository = $this->getDoctrine()->getRepository(Product::class);

        // Récupérer tous les produits
        $products = $productRepository->findAll();

        return $this->render('product/list.html.twig',[
            'products' => $products,
        ]);
    }
}
