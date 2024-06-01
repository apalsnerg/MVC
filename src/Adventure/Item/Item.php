<?php

namespace App\Adventure\Item;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */

class Item
{
    /** @var string $name the name of the item */
    public $name;

    /** @var int $value the value of the item */
    public $value;

    /** @var array<string> $attributes a list of attributes the item has */
    public $attributes = [];

    /** @var string $destroyMessage the line to be returned when the item is destroyed */
    public $destroyMessage;

    /** @var string $takeMessage the line to be returned when the item is taken */
    public $takeMessage;

    /** @var string $lookMessage the line to be returned when the item is looked at */
    public $lookMessage;

    /**
     * Creates the item.
     *
     * @param array<string> $attributes the attributes of the item
     */
    public function __construct(string $name, $attributes, int $value = 0, string | null $destroyMessage = null, string | null $takeMessage = null, string | null $lookMessage = null)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->value = $value;
        $this->destroyMessage = $destroyMessage ?? "This item appears to be indestructible, at least by any means you possess.";
        $this->takeMessage = $takeMessage ?? "You can't seem to find a way to fit this item in your bag.";
        $this->lookMessage = $lookMessage ?? "Junk.";
    }

    /** @return int the value of the item */
    public function getValue(): int
    {
        return $this->value;
    }
}
