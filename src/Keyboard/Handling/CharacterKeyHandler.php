<?php

namespace Mashbo\ConsoleToolkit\Keyboard\Handling;

interface CharacterKeyHandler extends KeyboardHandler
{
    public function character($char);
}
