<?php

namespace Mashbo\ConsoleToolkit\Tests\Functional;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Tests\Doubles\InputStreamStub;
use Mashbo\ConsoleToolkit\Tests\Doubles\OutputStreamSpy;

class MultipleChoiceQuestionTest extends \PHPUnit_Framework_TestCase
{
    public function test_pressing_enter_selects_no_choices()
    {
        $in = InputStreamStub::withInput(chr(10));
        $out = OutputStreamSpy::create();

        $terminal = new Terminal($in, $out);

        $helper = $terminal
            ->interaction()
            ->choice()
            ->multiple()
            ->build();

        $result = $helper->ask('A, B, or C?', ['A', 'B', 'C']);

        OutputStreamSpy::assertWrittenContents($out, "A, B, or C?\n \e[1m○ A\e[22m\n ○ B\n ○ C\n");
        $this->assertEquals([], $result);
    }

    public function test_pressing_down_then_space_then_enter_selects_second_choice()
    {
        $in = InputStreamStub::withInput("\e[B " . chr(10));
        $out = OutputStreamSpy::create();

        $terminal = new Terminal($in, $out);

        $helper = $terminal
            ->interaction()
            ->choice()
            ->multiple()
            ->build();

        $result = $helper->ask('A, B, or C?', ['A', 'B', 'C']);

        OutputStreamSpy::assertWrittenContents(
            $out,
            "A, B, or C?\n " .
            Ansi::bold("○ A") . "\n ○ B\n ○ C\n" .
            Ansi::cursorToStartOfLine() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() . Ansi::eraseToEndOfLine() .
            " ○ A" . "\n " . Ansi::bold("○ B") . "\n ○ C\n" .
            Ansi::cursorToStartOfLine() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() . Ansi::eraseToEndOfLine() .
            " ○ A" . "\n " . Ansi::bold(Ansi::green("● B")) . "\n ○ C\n"

        );
        $this->assertEquals(['B'], $result);
    }
}
