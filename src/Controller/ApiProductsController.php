<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api')]
class ApiProductsController extends AbstractController
{
    #[Route('/products', name: 'app_apiproducts_index', methods: ['GET'])]
    public function index(ProductsRepository $productsRepository): Response
    {

        // API URL: http://127.0.0.1:8000/api/products

        $products = $productsRepository->createQueryBuilder('p')
        ->select('p', 'c', 'pr')
        ->leftJoin('p.category', 'c')
        ->leftJoin('p.presentation', 'pr')
        ->getQuery()
        ->getResult();

        $data = [];

        foreach ($products as $pd) {
            $categoryData = [];
            $presentationData = [];

            // Obtenemos los datos de la entidad Category
            foreach ($pd->getCategory() as $category) {
                $categoryData[] = [
                    'id' => $category->getId(),
                    'typeCategory' => $category->getTypeCategory(),
                ];
            }

            // Obtenemos los datos de la entidad Presentation
            foreach ($pd->getPresentation() as $presentation) {
                $presentationData[] = [
                    'id' => $presentation->getId(),
                    'typePresentation' => $presentation->getTypePresentation(),
                ];
            }

            $data[] = [
                'id' => $pd->getId(),
                'name' => $pd->getName(),
                'description' => $pd->getDescription(),
                'price' => $pd->getPrice(),
                'quantity' => $pd->getQuantity(),
                'state' => $pd->isState(),
                'photo' => $pd->getPhoto(),
                'category' => $categoryData,
                'presentation' => $presentationData,
            ];
        }


        // dump($data);die;
        // return $this->json($data);
        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }

    #[Route('/products/{id}', name: 'app_apiproducts_show', methods: ['GET'])]
    public function show(int $id, ProductsRepository $productsRepository): Response
    {
        // API URL: http://127.0.0.1:8000/api/products/${id}

        $product = $productsRepository->createQueryBuilder('p')
            ->select('p', 'c', 'pr')
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.presentation', 'pr')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $categoryData = [];
        $presentationData = [];

        // Obtenemos los datos de la entidad Category
        foreach ($product->getCategory() as $category) {
            $categoryData[] = [
                'id' => $category->getId(),
                'typeCategory' => $category->getTypeCategory(),
            ];
        }

        // Obtenemos los datos de la entidad Presentation
        foreach ($product->getPresentation() as $presentation) {
            $presentationData[] = [
                'id' => $presentation->getId(),
                'typePresentation' => $presentation->getTypePresentation(),
            ];
        }

        $data = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity(),
            'state' => $product->isState(),
            'photo' => $product->getPhoto(),
            'category' => $categoryData,
            'presentation' => $presentationData,
        ];

        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }

    #[Route('/products/category/{category}', name: 'app_apiproducts_index_by_category', methods: ['GET'])]
public function indexByCategory(ProductsRepository $productsRepository, $category): Response
{
    $products = $productsRepository->createQueryBuilder('p')
        ->select('p', 'c', 'pr')
        ->leftJoin('p.category', 'c')
        ->leftJoin('p.presentation', 'pr')
        ->where('c.typeCategory = :category')
        ->setParameter('category', $category)
        ->getQuery()
        ->getResult();

        $data = [];

        foreach ($products as $pd) {
            $categoryData = [];
            $presentationData = [];

            // Obtenemos los datos de la entidad Category
            foreach ($pd->getCategory() as $category) {
                $categoryData[] = [
                    'id' => $category->getId(),
                    'typeCategory' => $category->getTypeCategory(),
                ];
            }

            // Obtenemos los datos de la entidad Presentation
            foreach ($pd->getPresentation() as $presentation) {
                $presentationData[] = [
                    'id' => $presentation->getId(),
                    'typePresentation' => $presentation->getTypePresentation(),
                ];
            }

            $data[] = [
                'id' => $pd->getId(),
                'name' => $pd->getName(),
                'description' => $pd->getDescription(),
                'price' => $pd->getPrice(),
                'quantity' => $pd->getQuantity(),
                'state' => $pd->isState(),
                'photo' => $pd->getPhoto(),
                'category' => $categoryData,
                'presentation' => $presentationData,
            ];
        }

        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }


}