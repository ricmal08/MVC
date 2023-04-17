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
            'sortedCards' => $sortedCards,
        ]);
    }

    #[Route('/card/deck/shuffle', name: 'card_deck_shuffle')]
    public function shuffleDeck(SessionInterface $session): Response
{
    // Hämta kortleken från sessionen
    $deck = $session->get('deck');

    // Skapa en ny kortlek om den inte finns i sessionen
    if (!$deck) {
        $deck = new DeckOfCards();
    }

    // Blanda kortleken
    $deck->shuffle();

    // Spara kortleken i sessionen
    $session->set('deck', $deck);

    return $this->redirectToRoute('card_deck');
}

    #[Route('/card/deck/draw', name: 'card_deck_draw')]
    public function drawCard(Request $request, SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        
        if (!$deck) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set('deck', $deck);
        }
        
        $drawnCard = $deck->drawCard();
        $remainingCards = count($deck->getCards());
        
        $drawnCards = $session->get('drawn_cards', []);
        $drawnCards[] = $drawnCard;
        $session->set('drawn_cards', $drawnCards);
        
        return $this->render('card/draw.html.twig', [
            'card' => $drawnCard,
            'remainingCards' => $remainingCards,
        ]);
    }

    #[Route('/card/deck/draw/{count}', name: 'card_deck_draw_count')]
        public function drawCount($count, Request $request, SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        
        if (!$deck) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set('deck', $deck);
        }
        
        $drawnCards = [];
        for ($i = 0; $i < $count; $i++) {
            $drawnCard = $deck->drawCard();
            $drawnCards[] = $drawnCard;
        }
        $remainingCards = count($deck->getCards());
        
        $previouslyDrawnCards = $session->get('drawn_cards', []);
        $drawnCards = array_merge($previouslyDrawnCards, $drawnCards);
        $session->set('drawn_cards', $drawnCards);
        
        return $this->render('card/count.html.twig', [
            'drawnCards' => $drawnCards,
            'remainingCards' => $remainingCards,
        ]);
    }
}
