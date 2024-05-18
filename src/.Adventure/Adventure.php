<?php

namespace Src\Adventure;

class Adventure {
    public $player;
    public $enemy;
    public $rooms = [];
    
    public function __construct() {
    $this->player = new Hero();
    $this->enemy = new Enemy();
    $this->rooms[] = new Entrance();
    $this->rooms[] = new Pathway();
    $this->rooms[] = new Encounter();
    $this->rooms[] = new Goal();
    }
}