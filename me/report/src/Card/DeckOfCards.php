<?php

namespace App\Card;

class DeckOfCards
{
    private array $cards;

    public function __construct()
    {
        $suits = ['hearts', 'diamonds', 'clubs', 'spades'];
        $ranks = ['ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'jack', 'queen', 'king'];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->cards[] = new CardGraphic($suit, $rank);
            }
        }
    }

    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    public function drawCard(): Card
{
    $card = array_shift($this->cards);
    switch ($card->rank) {
        case 'ace':
            $value = rand(1, 11);
            break;
        case 'king':
        case 'queen':
        case 'jack':
            $value = 10;
            break;
        default:
            $value = intval($card->rank);
            break;
    }
    $card->value = $value;
    return $card;
}

    public function dealHand(int $size): CardHand
    {
        $handCards = array_splice($this->cards, 0, $size);
        return new CardHand($handCards);
    }
}
