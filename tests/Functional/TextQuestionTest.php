<?php

namespace Mashbo\ConsoleToolkit\Tests\Functional;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Tests\Doubles\InputStreamStub;
use Mashbo\ConsoleToolkit\Tests\Doubles\OutputStreamSpy;

class TextQuestionTest extends \PHPUnit_Framework_TestCase
{
    public function test_typing_string_then_enter_returns_valid_string()
    {
        $in = InputStreamStub::withInput("World!" . chr(13));
        $out = OutputStreamSpy::create();

        $terminal = new Terminal($in, $out);

        $helper = $terminal
            ->interaction()
            ->text();

        $result = $helper->ask('Hello?');

        OutputStreamSpy::assertWrittenContents(
            $out,
            "Hello? " .
            "W"         . str_repeat(Ansi::backspace() . " " . Ansi::backspace(), 1) .
            "Wo"        . str_repeat(Ansi::backspace() . " " . Ansi::backspace(), 2) .
            "Wor"       . str_repeat(Ansi::backspace() . " " . Ansi::backspace(), 3) .
            "Worl"      . str_repeat(Ansi::backspace() . " " . Ansi::backspace(), 4) .
            "World"     . str_repeat(Ansi::backspace() . " " . Ansi::backspace(), 5) .
            "World!\n"
        );
        $this->assertEquals('World!', $result);
    }
}