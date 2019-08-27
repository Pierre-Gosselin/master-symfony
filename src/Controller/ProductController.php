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

        // Récupérer le produit le plus cher
        $productExpensive = $productRepository->findOneGreaterThanPrice(1400);


        return $this->render('product/demo.html.twig',[
            'products' => $products,
            'product_id' => $productId,
            'product_price' => $productsPrice,
            'product_name' => $productName,
            'product_expensive' => $productExpensive,
        ]);
    }

    /**
     * @Route("/product/delete/{id}",name="delete")
     */
    public function delete(Product $product)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        
        // On exécute la requête (DELETE...)
        $entityManager->flush();

        $this->addFlash('danger','Le produit a été supprimé');

        return $this->redirectToRoute('list');
    }

    /**
     * @Route("/product/update/{id}",name="update")
     */
    public function update(Request $request, Product $product)
    {

        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        if ($product != null)
        {
            // Quand le formulaire envoyé est valide
            if ($form->isSubmitted() && $form->isValid())
            {       
                // On récupère le manager Doctrine pour gérer la BDD
                $entityManager = $this->getDoctrine()->getManager();

                // Exécute la requête (INSERT...)
                $entityManager->flush();

                $this->addFlash('success','Le produit a été modifié');

                return $this->redirectToRoute('list');
            }
        }
        else
        {
            return $this->redirectToRoute('list');
        }


        return $this->render('product/update.html.twig',[
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
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAllWithUser()
        ;
        dump($products);
        return $this->render('product/list.html.twig',[
            'products' => $products,
        ]);
    }

    /**
     * @Route("/",name="home")
     *
     */
    public function home()
    {
        // Récupéer le repository de l'entité Product
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findMoreExpensive();
        ;

        dump($products);
        return $this->render('home.html.twig', [
            'products' => $products,
        ]);

    }
}
