<?php

namespace App\Cards;

/**
 * Class to practice inheritance.
*/
class GraphicCard extends Card
{
    public $graphic;
    
    public function __construct($value = null, $suit = null)
    {
        parent::__construct($value, $suit);
        $this->graphic = "[" . $this->value . $this->suit . "]";
    }

    public function graphic()
    {
        return $this->graphic;
    }

    public function stringToCard($str) {
        var_dump($str);
        trim($str, "[]");
        $suit = $str[0];
        ltrim($str, $str[0]);
        
        return new GraphicCard($str, $suit);
    }
}
