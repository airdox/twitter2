<?php

namespace App\Controller;

use App\Entity\ReTweet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Controller\PostController as PostController;
use App\Repository\ReTweetRepository;

class ReTweetController extends AbstractController
{
    /**
     * @Route("/retweet/{id}", name="retweet", methods={"GET","HEAD"})
     */
    public function index(Request $request, Post $post, ReTweetRepository $reTweetRepository): Response
    {   
        $rt = $reTweetRepository->findOneBy(array('user' => $this->getUser(), 'post' => $post));
        if($rt === null) {
            $retweet = new ReTweet();
            $retweet->setPost($post);
            $retweet->setUser($this->getUser());
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($retweet);
            $entityManager->flush();
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sendtweet');
        // return $this->render('retweet/index.html.twig', [
        //     'controller_name' => 'ReTweetController',
        // ]);
    }
}
