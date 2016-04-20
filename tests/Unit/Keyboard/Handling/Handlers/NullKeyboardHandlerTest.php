<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Keyboard\Handling\Handlers;

use Mashbo\ConsoleToolkit\Keyboard\Handling\Handlers\NullKeyboardHandler;

class NullKeyboardHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_is_syntactically_ok()
    {
        new NullKeyboardHandler();
    }
}
