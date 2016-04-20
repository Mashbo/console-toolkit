<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Widgets\Choice\Single;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\Tests\Support\BinaryStringTestHelper;
use Mashbo\ConsoleToolkit\Widgets\Choice\ChoiceList;
use Mashbo\ConsoleToolkit\Widgets\Choice\Single\SingleChoiceQuestionFormatter;
use Mashbo\ConsoleToolkit\Widgets\Choice\Single\SingleChoiceQuestionState;

class SingleChoiceQuestionFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function test_second_item_is_selected()
    {
        $expected = implode("\n", [
            " ○ A",
            " " . Ansi::green("➜ B"),
            " ○ C",
            ""
        ]);

        $sut = new SingleChoiceQuestionFormatter();
        BinaryStringTestHelper::assertEquals(
            $expected,
            $sut->format(
                new SingleChoiceQuestionState(
                    'Question',
                    ChoiceList::fromAssocArray(['A', 'B', 'C']),
                    1
                )
            )
        );
    }
    public function test_second_item_is_selected_with_string_keys()
    {
        $expected = implode("\n", [
            " ○ The letter A",
            " " . Ansi::green("➜ The letter B"),
            " ○ The letter C",
            ""
        ]);

        $sut = new SingleChoiceQuestionFormatter();
        BinaryStringTestHelper::assertEquals(
            $expected,
            $sut->format(
                new SingleChoiceQuestionState(
                    'Question',
                    ChoiceList::fromAssocArray(
                        [
                            'A' => 'The letter A',
                            'B' => 'The letter B',
                            'C' => 'The letter C'
                        ]
                    ),
                    'B'
                )
            )
        );
    }
}
