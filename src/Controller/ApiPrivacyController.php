<?php

namespace App\Controller;

use App\Entity\Privacy;
use App\Form\PrivacyType;
use App\Repository\PrivacyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiPrivacyController extends AbstractController
{
    #[Route('/privacy', name: 'app_apiprivacy_index', methods: ['GET'])]
    public function index(PrivacyRepository $privacyRepository): Response
    {
        // API URL: http://127.0.0.1:8000/api/privacy

        $privacy = $privacyRepository->findAll();

        $data = [];

        foreach ($privacy as $pv) {
            $data[] = [
                'id' => $pv->getId(),
                'description' => $pv->getDescription(),

            ];
        }
        // dump($data);die;
        // return $this->json($data);
        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }
}
