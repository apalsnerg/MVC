<?php

namespace App\Adventure\Room;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Entrance extends Room
{
    public function __construct()
    {
        $interactables = [];
        $entities = [];
        $texts = [];
        parent::__construct(0, ["W" => 1], $interactables, $entities);
    }
}