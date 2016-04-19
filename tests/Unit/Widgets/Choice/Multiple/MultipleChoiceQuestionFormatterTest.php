<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Widgets\Choice\Multiple;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\Tests\Support\BinaryStringTestHelper;
use Mashbo\ConsoleToolkit\Widgets\Choice\Multiple\MultipleChoiceQuestionFormatter;

class MultipleChoiceQuestionFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function test_first_and_second_items_are_selected()
    {
        $expected = implode("\n", [
            " " . Ansi::bold(Ansi::green("● A")),
            " " . Ansi::green("● B"),
            " ○ C",
            ""
        ]);

        $sut = new MultipleChoiceQuestionFormatter();
        BinaryStringTestHelper::assertEquals($expected, $sut->format(['A', 'B', 'C'], [0, 1], 0));
    }
}
