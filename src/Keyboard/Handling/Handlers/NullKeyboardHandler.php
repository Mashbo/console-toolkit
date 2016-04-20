<?php

namespace Mashbo\ConsoleToolkit\Keyboard\Handling\Handlers;

use Mashbo\ConsoleToolkit\Keyboard\Handling\ArrowKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\BackspaceKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\CharacterKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\EndKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\EnterKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\HomeKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\PageUpDownKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\TabKeyHandler;

class NullKeyboardHandler implements
    CharacterKeyHandler,
    ArrowKeyHandler,
    HomeKeyHandler,
    EndKeyHandler,
    PageUpDownKeyHandler,
    BackspaceKeyHandler,
    TabKeyHandler,
    EnterKeyHandler
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
