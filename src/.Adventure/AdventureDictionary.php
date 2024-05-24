<?php

namespace Src\Adventure;

class AdventureDictionary {

    public $destroyWords;

    public $takeWords;

    public $perceptionWords;

    public $observeWords;

    public $moveWords;

    public function __construct() {
        $this->destroyWords = ["hit", "punch", "kick", "attack", "destroy", "annihilate", "ora ora", "muda muda", "crush", "break", "swing at"];
    
        $this->takeWords = ["grab", "take", "pick up", "steal", "yoink", "nab", "snatch"];
    
        $this->perceptionWords = ["perceive", "look around", "peer", ];
    
        $this->observeWords = ["stare at", "look at", "gaze at"];

        $this->moveWords = ["move", "go", "translocate", "walk", "run", "sprint", "jog"];
    }
}
