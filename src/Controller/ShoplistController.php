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
        return $this->render('shoplist/create.html.twig', [
            'form' => $form,
            'shops' => $shops,
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
    public function remove(Shoplist $shop, \Doctrine\Persistence\ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $em->remove($shop);
        $em->flush();

        $this->addFlash(type: 'success', message: 'Položka byla odstraněna');

        return $this->redirect($this->generateUrl(route:'create'));
    }
}