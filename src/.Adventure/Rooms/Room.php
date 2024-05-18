<?php

namespace Src\Adventure;

/**
 * @codeCoverageIgnore
 */
class Room {
/**
 * @var array<mixed> $interactables interactable objects in the room
 * @var array<object> $texts text notes related to the room
 */
public $interactables = [];
public $entities = [];
public $texts = [];
}
