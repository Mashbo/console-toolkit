<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Widgets\Choice\Single;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\Tests\Support\BinaryStringTestHelper;
use Mashbo\ConsoleToolkit\Widgets\Choice\Single\SingleChoiceQuestionFormatter;

class SingleChoiceQuestionFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function test_first_item_is_selected()
    {
        $expected = implode("\n", [
            " ○ A",
            " " . Ansi::green("➜ B"),
            " ○ C",
            ""
        ]);

        $sut = new SingleChoiceQuestionFormatter();
        BinaryStringTestHelper::assertEquals($expected, $sut->format(['A', 'B', 'C'], 1));
    }
}
