<?php

namespace Src\Adventure;

/** Class to handle inputs during the game. */
class ActionHandler {

    public $dict = new AdventureDictionary();

    /** Evaluates the input and checks if it is valid in the submitted room 
     *
    * @param mixed $input the user input
    * @param Room $room the room to check the input for
    */
    public function evalInput($input, $room) {
        $input = explode(" ", $input);
        $target = $input[-1] ?? null;
        array_pop($input);
        $action = implode(" ", $input) ?? "";
        if ($target === null) {
            return "You attempt to" . $action . "nothing, and nothing happens...";
        }
    
        switch (true) {
        case(in_array($action, $this->dict->destroyWords)):
            if (in_array($target, $room->interactables) && in_array("destructible", $room->interactables[$target]->attributes)) {
                $message = $room->interactables[$target]->destroyMessage;
                $room->removeIteractable($target);
                return $message;
            }
            return "You attempt to" . $action . " " . $target . "." . "Nothing happens.";
        }
    }
}