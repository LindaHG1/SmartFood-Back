<?php

namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiStoreController extends AbstractController
{
    #[Route('/store', name: 'app_apistore_index', methods: ['GET'])]
    public function index(StoreRepository $storeRepository): Response
    {

        // API URL: http://127.0.0.1:8000/api/store

        // $store = $storeRepository->findAll();
        $store = $storeRepository->createQueryBuilder('s')
        ->select('s', 'sm')
        ->leftJoin('s.social', 'sm')
        ->getQuery()
        ->getResult();

        $data = [];

        foreach ($store as $store) {
            $socialData = [];

            // Obtenemos los datos de la entidad SocialMedia
            foreach ($store->getSocial() as $social) {
                $socialData [] = [
                    'id' => $social->getId(),
                    'nameicon' => $social->getNameicon(),
                    'linkicon' => $social->getLinkicon(),
                ];
            }

            $data[] = [
                'id' => $store->getId(),
                'address' => $store->getAddress(),
                'phone' => $store->getPhone(),
                'phone' => $store->getPhone(),
                'social' => $socialData,
            ];
        }
        // dump($data);die;
        // return $this->json($data);
        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }
}
