<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/sendtweet", name="sendtweet")
     */
    public function index(Request $request, PostRepository $postRepository, UserRepository $userRepository, AuthenticationUtils $authenticationUtils): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
        }

        $tweetsAll = [
            [
                "name" => "nameTweet",
                "date" => "Lundi 10 Janvier 2021"
            ],
            [
                "name" => "nameTweet2",
                "date" => "Mardi 11 Janvier 2021"
            ],
            [
                "name" => "nameTweet3",
                "date" => "Mercredi 12 Janvier 2021"
            ]
        ];

        $tweetsFilter = [
            [
                "name" => "nameTweet",
                "date" => "Lundi 10 Janvier 2021"
            ],
            [
                "name" => "nameTweet2",
                "date" => "Mardi 11 Janvier 2021"
            ]
        ];

        // dd($authenticationUtils->getLastUsername());

        return $this->render('post/index.html.twig', [
            'formPost' => $form->createView(),
            'tweets' => $postRepository->findAll(),
            'retweets' => ['tweet1', 'tweet2'],
            'users' => $userRepository->findAll(),
            'follows' => ['user1', 'user2']
        ]);
    }
}
