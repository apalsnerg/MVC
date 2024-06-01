<?php

namespace App\Adventure;

use App\Adventure\Item\Item;
use App\Adventure\Room;

/** Class to handle inputs during the game. */
class ActionHandler
{
    /**
     * @var AdventureDictionary $dict the dictionary of allowed words
     */
    public $dict;

    public function __construct()
    {
        $this->dict = new AdventureDictionary();
    }

    /** Evaluates the input and checks if it is valid in the submitted room
     *
    * @param string $input the user input
    * @param Room\Room $room the room to check the input for
    * @param Character\Hero $hero the hero character doing the action
    */
    public function evalInput($input, $room, $hero): string | null | int
    {
        $input = explode(" ", $input);
        $target = $input[-1];
        array_pop($input);
        $action = implode(" ", $input);
        if (count($input) < 2) {
            return "You attempt to $action nothing, and nothing happens...";
        }
        switch (true) {
            case (!in_array($target, $room->interactables)):
                return "There is no $target in this room.";

            case (in_array($action, $this->dict->takeWords)):
                /** @var Item $obj */
                $obj = $room->interactables[$target];
                if (in_array("takeable", $obj->attributes)) {
                    $message = $obj->takeMessage;
                    $hero->addItem($obj);
                    $room->removeIteractable($target);
                    return $message;
                }
                return null;

            case (in_array($action, $this->dict->lookWords)):
                /** @var object | Item $obj */
                $obj = $room->interactables[$target];
                return $obj->lookMessage ?? "You see a " . $target .
                    ". Nothing about it catches your eye.";

            case (in_array($action, $this->dict->moveWords)):
                if (in_array($target, $room->connectors)) {
                    /** @var Room\Room $roomTarget */
                    $roomTarget = $room->connectors[$target];
                    return $roomTarget->id;
                }
                return "You cannot go $target from here.";

            default:
                return "You attempt to" . $action . " " . $target . "." . "Nothing happens.";
        }
    }
}
