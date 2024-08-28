<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $representation = [
        'ace' => '🂡',
        '2' => '🂢',
        '3' => '🂣',
        '4' => '🂤',
        '5' => '🂥',
        '6' => '🂦',
        '7' => '🂧',
        '8' => '🂨',
        '9' => '🂩',
        '10' => '🂪',
        'jack' => '🂫',
        'queen' => '🂭',
        'king' => '🂮',
    ];

    public function getAsHtmlString(): string
    {
        $unicode = $this->representation[$this->rank];
        $color = $this->suit === 'hearts' || $this->suit === 'diamonds' ? 'red' : 'black';
        return "<span style=\"color: $color; font-size: 2em;\">$unicode</span>";
    }
}
