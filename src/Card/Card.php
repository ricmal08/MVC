<?php

namespace App\Card;

class Card
{
    public string $suit;
    public string $rank;
    public int $value = 0;

    public function __construct(string $suit, string $rank, int $value = 0)
    {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->value = $value;
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
