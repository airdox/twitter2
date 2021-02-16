<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index(): Response
    {

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

        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'tweetsAll' => $tweetsAll,
            'tweetsFilter' => $tweetsFilter
        ]);
    }
}
