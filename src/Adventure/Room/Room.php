<?php

namespace App\Adventure\Room;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Room
{
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
     *
     * @param int $id the id of the room
     * @param array<mixed> $connectors the id of the rooms this room connects to
     * @param array<object> $interactables the interactable objects in this room
     * @param array<object> $entities the entities in this room
     */
    public function __construct($id, $connectors, $interactables, $entities)
    {
        $this->id = $id;
        $this->connectors = $connectors;
        $this->interactables = $interactables;
        $this->entities = $entities;
    }

    /** @param string $target the name of the object to be removed */
    public function removeIteractable($target): void
    {
        unset($this->interactables[$target]);
    }

    /** @param string $target the name of the entity to be removed */
    public function removeEntity($target): void
    {
        unset($this->entities[$target]);
    }
}
