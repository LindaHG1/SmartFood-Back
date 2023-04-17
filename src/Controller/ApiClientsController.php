<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class ApiClientsController extends AbstractController
{
    #[Route('/clientslist', name: 'app_apiclients_index', methods: ['GET'])]
    public function index(ClientsRepository $clientsRepository): Response
    {
        // return $this->render('clients/index.html.twig', [
        //     'clients' => $clientsRepository->findAll(),
        // ]);

        $client = $clientsRepository->findAll(); 

        $data = [];

        foreach ($client as $cli) {
            $data[] = [
                'id' => $cli->getId(),
                'name' => $cli->getName(),
                'lastname' => $cli->getLastname(),
                'email' => $cli->getEmail(),
                'password' => $cli->getPassword(),
                'address' => $cli->getAddress()
            ];
        }
        // dump($ContactRepository ->findAll());
        // die;

        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }

    #[Route('/clients', name: 'app_apiclients_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $clients = new Clients();
        // var_dump($request);
        // exit(0);
        $name = $request->request->get('name');
        $lastname = $request->request->get('lastname');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $address = $request->request->get('address');

        $clients->setName($name);
        $clients->setLastname($lastname);
        $clients->setEmail($email);
        $clients->setPassword($password);
        $clients->setAddress($address);

        $entityManager->persist($clients);
        $entityManager->flush();
        
        // return $this->json(['message' => 'Mensaje enviado'], 201, ['Access-Control-Allow-Origin' => '*']);

        $response = $this->json(['message' => 'Mensaje enviado'], 201);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    #[Route('/clients', name: 'app_apiclients_get', methods: ['GET'])]
    public function getClientByEmail(Request $request, ClientsRepository $clientsRepository): JsonResponse
    {
        $email = $request->query->get('email');
        $client = $clientsRepository->findBy(['email' => $email]);

        $data = [];

        foreach ($client as $cli) {
            $data[] = [
                'id' => $cli->getId(),
                'name' => $cli->getName(),
                'lastname' => $cli->getLastname(),
                'email' => $cli->getEmail(),
                'password' => $cli->getPassword(),
                'address' => $cli->getAddress()
            ];
        }

        return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }

}
