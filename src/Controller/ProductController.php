<?php

namespace App\Controller;

use App\Form\Type\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Product;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager): Response
    {

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $product->setName('');
        $product->setDescription('');
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->render('product/index.html.twig', [
            'form' => $form,

        ]);

        return new Response('Saved new product with id '.$product->getId());
    }
}

