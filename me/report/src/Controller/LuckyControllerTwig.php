<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/api/quote", name: "api_quote")]
    public function apiQuote(): JsonResponse
    {
        // Define an array of quotes to choose from
        $quotes = [
            "The best way to predict the future is to invent it.",
            "Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.",
            "You don not have to be great to start, but you have to start to be great.",
        ];

        // Pick a random quote from the array
        $quote = $quotes[array_rand($quotes)];

        // Generate the response data
        $data = [
            'quote' => $quote,
            'date' => date('Y-m-d H:i:s', time()),
            'timestamp' => time(),
        ];

        // Create and return the JSON response
        return new JsonResponse($data);
    }

    #[Route("/lucky/number/twig", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route("/home", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        return $this->render('lucky.html.twig');
    }

}
