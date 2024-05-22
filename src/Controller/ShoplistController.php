<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Shoplist;
use App\Form\PostType;
use App\Form\ShoplistType;
use App\Repository\ShoplistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShoplistController extends AbstractController
{

    #[Route('/shoplist', name: 'app_shoplist')]
    public function index(ShoplistRepository $ShoplistRepository): Response
    {
        $shops = $ShoplistRepository->findAll();
        dump($shops);
        return $this->render('shoplist/index.html.twig', [
            'shops' => $shops

        ]);
    }
    #[Route('/shoplist/create', name: 'create')]
    public function create(Request $reguest, \Doctrine\Persistence\ManagerRegistry $doctrine)
    {
        //create a new post with title
        $shop= new Shoplist();

        $form = $this->createForm(ShoplistType::class, $shop);
        $form->handleRequest($reguest);
        if ($form->isSubmitted()){
            //entity manager

            $em = $doctrine->getManager();
                $em->persist($shop);
                $em->flush();



            return $this->redirect($this->generateUrl(route:'app_shoplist'));
        }

        //return a response
        return $this->render('shoplist/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/shoplist/show/{id}', name: 'show')]
    public function show(Shoplist $shop)
    {
        //Create the show view
        return $this->render('shoplist/show.html.twig', [
            'shop' => $shop

        ]);
    }

    #[Route('/post/delete/{id}', name: 'delete')]
    public function remove(Shoplist $shop, \Doctrine\Persistence\ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $em->remove($shop);
        $em->flush();

        $this->addFlash(type: 'success', message: 'Post was removed');

        return $this->redirect($this->generateUrl(route:'app_shoplist'));
    }
}