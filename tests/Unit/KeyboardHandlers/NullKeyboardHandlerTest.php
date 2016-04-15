<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\KeyboardHandlers;

use Mashbo\ConsoleToolkit\KeyboardHandlers\NullKeyboardHandler;

class NullKeyboardHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_is_syntactically_ok()
    {
        new NullKeyboardHandler();
    }
}