<?php

namespace App\Adventure;

use App\Adventure\Character\Hero;
use App\Adventure\Room\Room;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Adventure
{
    /** @var Hero $hero */
    public $hero;

    /** @var array<Room> $rooms */
    public $rooms = [];

    public function __construct(Hero $hero)
    {
        $this->hero = $hero;
        $this->rooms = [];
    }
}
