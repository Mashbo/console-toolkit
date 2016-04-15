<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Widgets\SingleChoiceQuestion;

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
            " " . Terminal::green("➜ B"),
            " ○ C",
            ""
        ]);

//        $expected = <<<TXT
// ○ A
// ${greenStart}➜ B${greenEnd}
// ○ C
//
//TXT;
        $sut = new SingleChoiceQuestionFormatter();
        $this->assertEquals($expected, $sut->format(['A', 'B', 'C'], 1));
    }
}
