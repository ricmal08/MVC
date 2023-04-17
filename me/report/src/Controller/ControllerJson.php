<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerJson extends AbstractController
{
    #[Route("/api", name: "api_index")]
    public function apiIndex(): Response
    {
        $routes = [
            ['path' => '/api/quote', 'description' => 'Returns a random quote.']
            
            // ...
        ];
    
        return $this->render('api/index.html.twig', ['routes' => $routes]);
    }
    
}