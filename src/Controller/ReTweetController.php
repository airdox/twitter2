<?php

namespace App\Controller;

use App\Entity\ReTweet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;

class ReTweetController extends AbstractController
{
    /**
     * @Route("/retweet/{id}", name="retweet", methods={"GET","HEAD"})
     */
    public function index(Request $request, Post $post): Response
    {
        $retweet = new ReTweet();
        $retweet->setPost($post);
        $retweet->setUser($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($retweet);
        $entityManager->flush();

        // return $this->redirectToRoute('homepage');
        return $this->render('retweet/index.html.twig', [
            'controller_name' => 'ReTweetController',
        ]);
    }
}
