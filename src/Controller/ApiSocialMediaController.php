<?php

namespace App\Controller;

use App\Entity\SocialMedia;
use App\Form\SocialMediaType;
use App\Repository\SocialMediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiSocialMediaController extends AbstractController
{
    #[Route('/socialmedia', name: 'app_apisocialmedia_index', methods: ['GET'])]
    public function index(SocialMediaRepository $socialMediaRepository): Response
    {
        // return $this->render('social_media/index.html.twig', [
        //     'social_media' => $socialMediaRepository->findAll(),
        // ]);

        // API URL: http://127.0.0.1:8000/api/socialmedia

        $socialMedia = $socialMediaRepository->findAll();

        $data = [];

        foreach ($socialMedia as $sm) {
            $data[] = [
                'id' => $sm->getId(),
                'nameicon' => $sm->getNameicon(),
                'linkicon' => $sm->getLinkicon(),

            ];
        }
        // dump($data);die;
        // return $this->json($data);
        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }
}
