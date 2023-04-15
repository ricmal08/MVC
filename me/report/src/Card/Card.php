<?php

namespace App\Card;

class Card
{
    private string $suit;
    private string $rank;
    public int $value;

    public function __construct(string $suit, string $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getRank(): string
    {
        return $this->rank;
    }

    public function __toString(): string
    {
        return "{$this->rank} of {$this->suit}";
    }

    public function getValue(): int
    {
        return $this->value;
    }
}