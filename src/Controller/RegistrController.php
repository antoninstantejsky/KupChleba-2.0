<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class RegistrController extends AbstractController
{
    #[Route('/registr', name: 'app_registr')]

    public function search(Request $request): Response
    {
        $data = ['query' => null];
        $form = $this->createFormBuilder($data)
            ->add('jmeno', TextType::class,['label' => 'Jméno'])
            ->add('prijmeni', TextType::class,['label' => 'Přijmení'])
            ->add('email', EmailType::class,['label' => 'Email'])
            ->add('search', SubmitType::class, ['label' => 'Search'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Zde bychom mohli provést logiku pro vyhledávání
            // například $results = $this->searchService->search($data['query']);

            return $this->render('search/results.html.twig', [
                'results' => $results, // předpokládáme, že máme nějaké výsledky vyhledávání
            ]);
        }

        return $this->render('registr/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}