<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Keyboard\Handling\Handlers;

use Mashbo\ConsoleToolkit\Keyboard\Handling\Handlers\EchoKeyboardHandler;

class EchoKeyboardHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_characters_are_forwarded_to_output_stream()
    {
        $out = fopen('php://memory', 'w');
        $sut = new EchoKeyboardHandler($out);

        $sut->character('a');
        rewind($out);
        $this->assertEquals('a', fgets($out));

        $sut->character('b');
        rewind($out);
        $this->assertEquals('ab', fgets($out));
    }
}
