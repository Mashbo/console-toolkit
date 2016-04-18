<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Widgets\SingleChoiceQuestion;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion\SingleChoiceQuestionFormatter;

class SingleChoiceQuestionFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function test_first_item_is_selected()
    {
        $greenStart = chr(27)."[32m";
        $greenEnd   = chr(27)."[0m";

        $expected = implode("\n", [
            " ○ A",
            " " . Ansi::green("➜ B"),
            " ○ C",
            ""
        ]);

        $sut = new SingleChoiceQuestionFormatter();
        $this->assertEquals($expected, $sut->format(['A', 'B', 'C'], 1));
    }
}
