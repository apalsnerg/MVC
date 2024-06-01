<?php

namespace App\Adventure;

class AdventureDictionary
{
    /** @var array<string> $destroyWords */
    public $destroyWords;

    /** @var array<string> $takeWords */
    public $takeWords;

    /** @var array<string> $perceptionWords */
    public $perceptionWords;

    /** @var array<string> $lookWords */
    public $lookWords;

    /** @var array<string> $moveWords */
    public $moveWords;

    public function __construct()
    {
        $this->destroyWords = ["hit", "punch", "kick", "attack", "destroy", "annihilate", "ora ora", "muda muda", "crush", "break", "swing at"];

        $this->takeWords = ["grab", "take", "pick up", "steal", "yoink", "nab", "snatch"];

        $this->perceptionWords = ["perceive", "look around", "peer", ];

        $this->lookWords = ["stare at", "look at", "gaze at"];

        $this->moveWords = ["move", "go", "translocate", "walk", "run", "sprint", "jog"];
    }
}
