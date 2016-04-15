<?php

namespace Mashbo\ConsoleToolkit\KeyboardHandlers;

use Mashbo\ConsoleToolkit\KeyboardHandler;

class NullKeyboardHandler implements KeyboardHandler
{
    public function character($char) {}
    public function leftArrow() {}
    public function rightArrow() {}
    public function upArrow() {}
    public function downArrow() {}
    public function home() {}
    public function end() {}
    public function pageUp() {}
    public function pageDown() {}
    public function backspace() {}
    public function tab() {}
    public function enter() {}
}
