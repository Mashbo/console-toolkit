<?php

namespace Mashbo\ConsoleToolkit\Keyboard\Handling;

interface ArrowKeyHandler extends KeyboardHandler
{
    public function leftArrow();
    public function rightArrow();
    public function upArrow();
    public function downArrow();
}
