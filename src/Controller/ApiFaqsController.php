<?php

namespace App\Controller;

use App\Entity\Faqs;
use App\Form\FaqsType;
use App\Repository\FaqsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiFaqsController extends AbstractController
{
    #[Route('/faqs', name: 'app_apifaqs_index', methods: ['GET'])]
    public function index(FaqsRepository $faqsRepository): Response
    {
        // API URL: http://127.0.0.1:8000/api/faqs

        $faqs = $faqsRepository->findAll();

        $data = [];

        foreach ($faqs as $fq) {
            $data[] = [
                'id' => $fq->getId(),
                'question' => $fq->getQuestion(),
                'answer' => $fq->getAnswer(),
            ];
        }
        // dump($data);die;
        // return $this->json($data);
        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }
}
