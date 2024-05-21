<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Category;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class PostController extends AbstractController
{

    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        dump($posts);
        return $this->render('post/index.html.twig', [
            'posts' => $posts

        ]);
    }


    #[Route('/post/create', name: 'create')]
    public function create(Request $reguest, \Doctrine\Persistence\ManagerRegistry $doctrine)
    {
        //create a new post with title
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($reguest);
        if ($form->isSubmitted()){
            //entity manager

            $em = $doctrine->getManager();

            $file = $reguest->files->get(key: 'post')['image'];
            if( $file) {
                $filename = md5(uniqid()). '.'. $file->guessClientExtension();
                $file->move(
                    $this->getParameter(name: 'uploads_dir'),
                    $filename
                );

                $post->setImage($filename);
                $em->persist($post);
                $em->flush();
            }


            return $this->redirect($this->generateUrl(route:'app_post'));
        }

        //return a response
        return $this->render('post/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/post/show/{id}', name: 'show')]
    public function show(Post $post)
    {
        //Create the show view
        return $this->render('post/show.html.twig', [
            'post' => $post

        ]);
    }

    #[Route('/post/delete/{id}', name: 'delete')]
    public function remove(Post $post, \Doctrine\Persistence\ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash(type: 'success', message: 'Post was removed');

        return $this->redirect($this->generateUrl(route:'app_post'));
    }
}
