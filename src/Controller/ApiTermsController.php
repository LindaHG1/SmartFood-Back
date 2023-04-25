<?php

namespace App\Controller;

use App\Entity\Terms;
use App\Form\TermsType;
use App\Repository\TermsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiTermsController extends AbstractController
{
    #[Route('/terms', name: 'app_apiterms_index', methods: ['GET'])]
    public function index(TermsRepository $termsRepository): Response
    {

        // API URL: http://127.0.0.1:8000/api/terms

        $terms = $termsRepository->findAll();

        $data = [];

        foreach ($terms as $tr) {
            $data[] = [
                'id' => $tr->getId(),
                'description' => $tr->getDescription(),

            ];
        }
        // dump($data);die;
        // return $this->json($data);
        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }
}
