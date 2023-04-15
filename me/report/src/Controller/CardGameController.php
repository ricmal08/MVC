<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route('/card/deck', name: 'card_deck')]
    public function showDeck(): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();
    
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $sortedCards = [];
    
        foreach ($suits as $suit) {
            $cardsInSuit = [];
            for ($value = 1; $value <= 10; $value++) {
                $card = $deck->drawCard($suit, $value);
                $cardsInSuit[] = $card;
            }
            usort($cardsInSuit, fn($a, $b) => $a->getValue() <=> $b->getValue());
            $sortedCards[$suit] = $cardsInSuit;
        }
    
        return $this->render('card/deck.html.twig', [
            'cards' => $sortedCards,
        ]);
    }
    
}
