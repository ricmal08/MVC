<?php

namespace App\Card;

class CardHand
{
    private array $cards;

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }
}
