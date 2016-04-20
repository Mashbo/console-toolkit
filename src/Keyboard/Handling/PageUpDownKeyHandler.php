<?php

namespace Mashbo\ConsoleToolkit\Keyboard\Handling;

interface PageUpDownKeyHandler extends KeyboardHandler
{
    public function pageUp();
    public function pageDown();
}
