<?php

namespace App\Controller;

use App\Entity\Addlist;
use App\Entity\Post;
use App\Entity\Shoplist;
use App\Form\PostType;
use App\Form\ShoplistType;
use App\Repository\AddlistRepository;
use App\Repository\ShoplistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShoplistController extends AbstractController
{
    public function show(TokenStorageInterface $tokenStorage): Response
    {
        $user = $tokenStorage->getToken()->getUser();

        if (!$user instanceof \App\Entity\User) {
            throw new AccessDeniedHttpException('This user cannot be accessed');
        }

        return $this->render('shoplist/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/shoplist', name: 'app_shoplist')]
    public function index(Request $request, \Doctrine\Persistence\ManagerRegistry $doctrine,
                          TokenStorageInterface $tokenStorage, ): Response
    {
        $user = $tokenStorage->getToken()->getUser();
        $userId = $user->getId();
        $form = $this->createFormBuilder()
            ->add('name')
            ->add('add', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-success float- right'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();

            $list = new Addlist();
            $list->setName($data['name']);
            $list->setUserId($userId);

            dump($list);
            $em = $doctrine->getManager();

            $em->persist($list);
            $em->flush();
            $name = (string) $list->getName();
            return $this->redirect($this->generateUrl('create',['name'=>$name]));
        }
        return $this->render('shoplist/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/shoplist/create/{name}', name: 'create')]
    public function create(ShoplistRepository $ShoplistRepository, AddlistRepository $addlistRepository,
                           Request $reguest,
                           \Doctrine\Persistence\ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage)
    {
        //create a new post with title
        $shop= new Shoplist();

        $user = $tokenStorage->getToken()->getUser();
        $userId = $user->getId();
        $name = $reguest->get('name');
        $form = $this->createForm(ShoplistType::class, $shop);
        $form->handleRequest($reguest);
        if ($form->isSubmitted()){
            //entity manager
            $shop->setUserId($userId);

            $shop->setShop($name);
            $em = $doctrine->getManager();
                $em->persist($shop);
                $em->flush();



            return $this->redirect($this->generateUrl('create',['name'=>$name]));
        }

        //return a response
        $shops = $ShoplistRepository->findBy(['user_id'=>$userId, 'shop'=>$name]);
        dump($shops);
        $groupedShops = [];
        foreach ($shops as $shop) {
            if (!isset($groupedShops[$shop->getCategory()])) {
                $groupedShops[$shop->getCategory()] = [];
            }
            $groupedShops[$shop->getCategory()][] = $shop;
        }
        $totalCost = array_reduce($shops, function ($carry, $shop) {
            return $carry + ($shop->getQuantity() * $shop->getValue());
        }, 0);
        return $this->render('shoplist/create.html.twig', [
            'form' => $form,
            'shops' => $shops,
            'groupedShops' => $groupedShops,
            'totalCost' => $totalCost
        ]);
    }

    #[Route('/shoplist/showlist', name: 'showlist')]
    public function showlist(AddlistRepository $addlistRepository, request $request,
                             TokenStorageInterface $tokenStorage, \Doctrine\Persistence\ManagerRegistry $doctrine)
    {
        //Create the show view
        $user = $tokenStorage->getToken()->getUser();
        $userId = $user->getId();
        $lists = $addlistRepository->findBy(['userId'=>$userId]);
        return $this->render('shoplist/showlist.html.twig', [
            'lists' => $lists

        ]);
    }
    #[Route('/shoplist/show/{id}', name: 'show')]
    public function showid(Shoplist $shop)
    {
        //Create the show view
        return $this->render('shoplist/show.html.twig', [
            'shop' => $shop

        ]);
    }

    #[Route('/Shoplist/delete/{id}', name: 'delete')]
    public function remove(Request $request, Shoplist $shop, \Doctrine\Persistence\ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $em->remove($shop);
        $em->flush();

        $this->addFlash(type: 'success', message: 'Položka byla odstraněna');

        $refererUrl = $request->headers->get('referer');

        if ($refererUrl && filter_var($refererUrl, FILTER_VALIDATE_URL)) {
            return $this->redirect($refererUrl);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    #[Route('/shoplist/buy/{name}', name: 'buy')]
    public function buy( Request $reguest, TokenStorageInterface $tokenStorage,
                         ShoplistRepository $ShoplistRepository, AddlistRepository $addlistRepository)
    {
        $user = $tokenStorage->getToken()->getUser();
        $userId = $user->getId();
        $name = $reguest->get('name');
        $shops = $ShoplistRepository->findBy(['user_id'=>$userId, 'shop'=>$name]);
        $list = $addlistRepository->findOneBy(['name'=>$name]);
        $groupedShops = [];
        foreach ($shops as $shop) {
            if (!isset($groupedShops[$shop->getCategory()])) {
                $groupedShops[$shop->getCategory()] = [];
            }
            $groupedShops[$shop->getCategory()][] = $shop;
        }
        $totalCost = array_reduce($shops, function ($carry, $shop) {
            return $carry + ($shop->getQuantity() * $shop->getValue());
        }, 0);
        //Create the show view
        return $this->render('shoplist/buy.html.twig', [
            'shops' => $shops,
            'list' => $list,
            'groupedShops' => $groupedShops,
            'totalCost' => $totalCost
        ]);

    }

    #[Route('/Shoplist/bought/{id}', name: 'bought')]
    public function bought(int $id, Request $request, \Doctrine\Persistence\ManagerRegistry $doctrine,
                           ShoplistRepository $ShoplistRepository)
    {
        try {
            $ShoplistRepository->boughtItem($id);

            // Získání URL předchozí stránky z referer headeru
            $refererUrl = $request->headers->get('referer');

            // Kontrola, zda referer existuje a je validní URL
            if ($refererUrl && filter_var($refererUrl, FILTER_VALIDATE_URL)) {
                // Přesměrování zpět na předchozí stránku
                return $this->redirect($refererUrl);
            } else {
                // Pokud referer není dostupný nebo validní, přesměrujeme na domovskou stránku nebo jinou standardní stránku
                return $this->redirectToRoute('home');
            }

        } catch (\Exception $e) {
            // Zde můžete přidat logování chyby pro lepší diagnostiku
            return new Response('Došlo k chybě.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}