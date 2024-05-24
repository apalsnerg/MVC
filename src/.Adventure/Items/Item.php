<?php

namespace Src\Adventure;
/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */

class Item {

    public $name;
    public $value;
    public $attributes = [];
    
    public $destroyMessage;

    public $takeMessage;

    public $lookMessage;

    public function __construct($name, $attributes, $value=0, $destroyMessage = null, $takeMessage = null, $lookMessage = null)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->value = $value;
        $this->destroyMessage = $destroyMessage ?? "This item appears to be indestructible, at least by any means you possess.";
        $this->takeMessage = $takeMessage ?? "You can't seem to find a way to fit this item in your bag.";
        $this->lookMessage = $lookMessage ?? "Junk.";
    }

    public function getValue()
    {
        return $this->value;
    }
}
