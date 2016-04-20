<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Widgets\Choice\Single;

use Mashbo\ConsoleToolkit\Widgets\Choice\ChoiceList;
use Mashbo\ConsoleToolkit\Widgets\Choice\Single\SingleChoiceQuestionState;

class SingleChoiceQuestionStateTest extends \PHPUnit_Framework_TestCase
{
    public function test_can_cycle_through_numeric_indicies()
    {
        $sut = new SingleChoiceQuestionState(
            'My question',
            ChoiceList::fromAssocArray(['A', 'B', 'C']),
            0
        );
        $this->assertEquals(0, $sut->selectedIndex());
        $this->assertTrue($sut->indexIsSelected(0));
        $sut->downArrow();
        $this->assertEquals(1, $sut->selectedIndex());
        $this->assertTrue($sut->indexIsSelected(1));
    }
    public function test_cycle_loops_to_beginning()
    {
        $sut = new SingleChoiceQuestionState(
            'My question',
            ChoiceList::fromAssocArray(['A', 'B', 'C']),
            2
        );
        $sut->downArrow();
        $this->assertEquals(0, $sut->selectedIndex());
        $this->assertTrue($sut->indexIsSelected(0));
    }
    public function test_can_cycle_through_string_indicies()
    {
        $sut = new SingleChoiceQuestionState(
            'My question',
            ChoiceList::fromAssocArray(['A' => 'X', 'B' => 'Y', 'C' => 'Z']),
            'B'
        );
        $this->assertEquals('B', $sut->selectedIndex());
        $this->assertTrue($sut->indexIsSelected('B'));
        $sut->downArrow();
        $this->assertEquals('C', $sut->selectedIndex());
        $this->assertTrue($sut->indexIsSelected('C'));
        $sut->downArrow();
        $this->assertEquals('A', $sut->selectedIndex());
        $this->assertTrue($sut->indexIsSelected('A'));
    }

}