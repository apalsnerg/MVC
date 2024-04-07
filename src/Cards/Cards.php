<?php
class Card {
    public $suit;
    public $value;
    
    public function __construct($value=null, $suit=null) {
    $values = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    if (is_null($value)) {
    $this->value = $values[random_int(0, 12)];
    } else {
    $this->value = $value;
    }
    
    $suits = ["C", "D", "H", "S"];
    if (is_null($suit)) {
    $this->suit = $suits[random_int(0, 3)];
    } else {
    $this->suit = $suit;
        }
    }
}
    
    
    class GraphicCard extends Card {
    
    public function __construct() {
        parent::__construct(NULL);
    }
    
    public function graphic() {
    return $this->suit . $this->value;
    }
    
}

class CardHand {
    
}


class DeckOfCards {

}
