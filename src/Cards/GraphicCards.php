<?php

namespace App\Cards;

/**
 * Class to practice inheritance.
*/
class GraphicCard extends Card
{
    public $graphic;
    
    public function __construct()
    {
        parent::__construct(null);
        $this->graphic = "[" . $this->suit . $this->value . "]";
    }

    public function graphic()
    {
        return $this->graphic;
    }
}
