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

    public function drawCard(): ?CardGraphic
    {
        $remainingCards = count($this->cards);

        if ($remainingCards === 0) {
            return null;
        }

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
                $value = $card->rank;
        }

        return new CardGraphic($card->suit, $card->rank, $value);
    }

    public function dealHand(int $size): CardHand
    {
        $handCards = array_splice($this->cards, 0, $size);
        return new CardHand($handCards);
    }

    public function getCards(): array
    {
        $card = $this->drawCard();
        $remainingCards = count($this->cards);
        $this->cards[] = $card;
        return [
            'card' => $card,
            'remainingCards' => $remainingCards,
        ];
    }
    public function dealCard(): Card
    {
        return array_shift($this->cards);
    }

    public function getSize(): int
    {
        return count($this->cards);
    }
}
