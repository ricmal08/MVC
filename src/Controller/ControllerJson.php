<?php

namespace App\Controller;

use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ControllerJson extends AbstractController
{
    #[Route("/api", name: "api_index")]
    public function apiIndex(): Response
    {
        $routes = [
            ['path' => '/api/quote', 'description' => 'Returns a random quote.'],
            ['path' => '/api/draw', 'description' => 'Returns a random card from Card Deck.'],
            ['path' => '/api/deck', 'description' => 'Returns a the complete Card Deck.'],
            ['path' => '/api/shuffle', 'description' => 'Returns a shuffled Card Deck.'],
            ['path' => '/api/draw/:number', 'description' => 'Returns a given number of cards from Card Deck.']

            // ...
        ];

        return $this->render('api/index.html.twig', ['routes' => $routes]);
    }

    #[Route("/api/deck", name: "api_deck")]
    public function apiDeck(): JsonResponse
    {
        $cards = [];

        $suits = ['hearts', 'diamonds', 'clubs', 'spades'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $cards[] = ['suit' => $suit, 'value' => $value];
            }
        }

        // Sort cards by suit and then by value
        usort($cards, function ($a, $b) use ($suits, $values) {
            if ($a['suit'] == $b['suit']) {
                return array_search($a['value'], $values) - array_search($b['value'], $values);
            } else {
                return array_search($a['suit'], $suits) - array_search($b['suit'], $suits);
            }
        });

        // Create and return the JSON response
        return new JsonResponse($cards);
    }

    #[Route('/api/deck/shuffle', name: 'api_deck_shuffle', methods: ['GET'])]
    public function apiDeckShuffle(Request $request): JsonResponse
    {
        $cards = $this->getCards();

        shuffle($cards);

        return new JsonResponse($cards);
    }

    private function getCards(): array
    {
        $cards = [];

        $suits = ['hearts', 'diamonds', 'clubs', 'spades'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $cards[] = ['suit' => $suit, 'value' => $value];
            }
        }

        return $cards;
    }

    #[Route('/api/deck/draw', name: 'api_deck_draw', methods: ['GET'])]
    public function drawOneCard(Request $request)
    {
        // Get the deck from the session
        $deck = $request->getSession()->get('deck');

        // If the deck is not in the session, create a new one
        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $request->getSession()->set('deck', $deck);
        }

        // Draw one card from the deck
        $card = $deck->drawCard();

        // Save the deck back to the session
        $request->getSession()->set('deck', $deck);

        // Return the response as JSON
        return new JsonResponse([
            'card' => $card,
            'remaining' => $deck->getSize(),
        ]);
    }

    #[Route('/api/deck/draw/{number}', name: 'api_deck_draw_number', methods: ['GET'])]
    public function drawMultipleCards(Request $request, $number)
    {
        // Get the deck from the session
        $deck = $request->getSession()->get('deck');

        // If the deck is not in the session, create a new one
        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $request->getSession()->set('deck', $deck);
        }

        // Draw the specified number of cards from the deck
        $cards = [];
        for ($i = 0; $i < $number; $i++) {
            $card = $deck->drawCard();
            if ($card instanceof CardGraphic) {
                $cards[] = $card;
            } else {
                break;
            }
        }

        // Save the deck back to the session
        $request->getSession()->set('deck', $deck);

        // Return the response as JSON
        return new JsonResponse([
            'cards' => $cards,
            'remaining' => $deck->getSize(),
        ]);
    }

}
