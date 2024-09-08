<?php

namespace App\Controller;

use App\Entity\Addlist;
use App\Entity\Shoplist;
use App\Repository\AddlistRepository;
use App\Repository\ShoplistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Controller\ShoplistController;

class AddlistController extends AbstractController
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

    #[Route('/addlist/delete/{id}', name: 'shop_delete')]
    public function remove(Addlist $shop, \Doctrine\Persistence\ManagerRegistry $doctrine,
                           ShoplistRepository $shoplistRepository, TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();
        $userId = $user->getId();
        $name = $shop->getName();
        $sorts = $shoplistRepository->findBy(['user_id'=>$userId, 'shop'=>$name]);
        $em = $doctrine->getManager();
        foreach ($sorts as $sort) {
            $em->remove($sort);
        }
        $em->remove($shop);
        $em->flush();

        $this->addFlash(type: 'success', message: 'Seznam byl odstraněn');

        return $this->redirect($this->generateUrl(route:'showlist'));
    }
    #[Route('/addlist/bought/{id}', name: 'shop_bought')]
    public function shop_bought(int $id, Request $request, \Doctrine\Persistence\ManagerRegistry $doctrine, AddlistRepository $addlistRepository)
    {
        try {
            $addlistRepository->boughtItem($id);

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
