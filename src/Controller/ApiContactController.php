<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class ApiContactController extends AbstractController
{
    #[Route('/contactlist', name: 'app_apicontact_index', methods: ['GET'])]
    public function index(ContactRepository $ContactRepository): Response
    { 
        $contact = $ContactRepository->findAll(); 

        $data = [];

        foreach ($contact as $c) {
            $data[] = [
                'id' => $c->getId(),
                'name' => $c->getName(),
                'email' => $c->getEmail(),
                'message' => $c->getMessage()
            ];
        }
        // dump($ContactRepository ->findAll());
        // die;

        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }

    #[Route('/contact', name: 'app_apicontact_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $contact = new Contact();
        // var_dump($request);
        // exit(0);
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $message = $request->request->get('message');

        $contact->setName($name);
        $contact->setEmail($email);
        $contact->setMessage($message);

        $entityManager->persist($contact);
        $entityManager->flush();
        
        // return $this->json(['message' => 'Mensaje enviado'], 201, ['Access-Control-Allow-Origin' => '*']);

        $response = $this->json(['message' => 'Mensaje enviado'], 201);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

}