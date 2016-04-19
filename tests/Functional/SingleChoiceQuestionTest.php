<?php

namespace Mashbo\ConsoleToolkit\Tests\Functional;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Tests\Doubles\InputStreamStub;
use Mashbo\ConsoleToolkit\Tests\Doubles\OutputStreamSpy;

class SingleChoiceQuestionTest extends \PHPUnit_Framework_TestCase
{
    public function test_pressing_enter_selects_first_choice()
    {
        $in = InputStreamStub::withInput(chr(10));
        $out = OutputStreamSpy::create();

        $terminal = new Terminal($in, $out);

        $helper = $terminal
            ->interaction()
            ->choice()
            ->single()
            ->build();

        $result = $helper->ask('A, B, or C?', ['A', 'B', 'C']);

        OutputStreamSpy::assertWrittenContents($out, "A, B, or C?\n \e[32m➜ A\e[39m\n ○ B\n ○ C\n");
        $this->assertEquals('A', $result);
    }

    public function test_pressing_down_then_enter_selects_second_choice()
    {
        $in = InputStreamStub::withInput("\e[B" . chr(10));
        $out = OutputStreamSpy::create();

        $terminal = new Terminal($in, $out);

        $helper = $terminal
            ->interaction()
            ->choice()
            ->single()
            ->build();

        $result = $helper->ask('A, B, or C?', ['A', 'B', 'C']);

        OutputStreamSpy::assertWrittenContents(
            $out,
            "A, B, or C?\n " .
            "\e[32m➜ A\e[39m\n ○ B\n ○ C\n" .
            Ansi::cursorToStartOfLine() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() . Ansi::eraseToEndOfLine() .
            " ○ A\n \e[32m➜ B\e[39m\n ○ C\n"
        );
        $this->assertEquals('B', $result);
    }
}
