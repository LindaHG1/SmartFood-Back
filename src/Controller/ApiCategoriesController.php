<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiCategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_apicategories_index', methods: ['GET'])]
    public function index(CategoriesRepository $categoriesRepository): Response
    {

        // API URL: http://127.0.0.1:8000/api/categories

        $category = $categoriesRepository->findAll();

        $data = [];

        foreach ($category as $cat) {
            $data[] = [
                'id' => $cat->getId(),
                'typecategory' => $cat->getTypecategory(),
                'photo' => $cat->getPhoto(),

            ];
        }
        // dump($data);die;
        // return $this->json($data);
        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }

    #[Route('/categories/{id}', name: 'app_apicategories_show', methods: ['GET'])]
    public function show(int $id, CategoriesRepository $categoriesRepository): Response
    {

        // API URL: http://127.0.0.1:8000/api/categories/${id}
        // $category = $categoriesRepository->findAll();

        $category = $categoriesRepository->createQueryBuilder('cat')
            ->select('cat')
            ->where('cat.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        $data = [
            'id' => $category->getId(),
                'typecategory' => $category->getTypecategory(),
                'photo' => $category->getPhoto(),
        ];

        // dump($data);die;
        // return $this->json($data);
        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }

}
