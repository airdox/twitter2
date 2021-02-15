<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

     /**
     * @Route("/subscribe/{id}", name="subscribe", methods={"GET","HEAD"})
     */
    public function subcribe(Request $request, User $user): Response
    {
       $currentUser = $this->getUser();
       $currentUser->addSubscribe($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // return $this->redirectToRoute('homepage');
        return $this->render('retweet/index.html.twig', [
            'controller_name' => 'ReTweetController',
        ]);
    }
}
