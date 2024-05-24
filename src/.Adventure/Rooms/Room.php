<?php

namespace Src\Adventure;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Room {
    /**
     * @var int $id the id of the room
     */
    public $id;

    /**
     * @var array<mixed> $connectors an array of connected rooms
     */
    public $connectors;

    /**
     * @var array<mixed> $interactables interactable objects in the room
    */
    public $interactables = [];
    
    /**
     * @var array<object> $entities entities present in the room
    */
    public $entities = [];
    
    /**
     * @var array<object> $texts text notes related to the room
    */
    public $texts = [];

    /**
     * Constructs the room.
     */
    public function __construct($id, $connectors, $interactables, $entities, $texts) {
        $this->id = $id;
        $this->connectors = $connectors;
        $this->interactables = $interactables;
        $this->entities = $entities;
        $this->texts = $texts;
    }
    public function removeIteractable($target) {
        unset($this->interactables[$target]);
    }
    
    public function removeEntity($target) {
        unset($this->entities[$target]);
    }
}
