<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit;

use Mashbo\ConsoleToolkit\Keyboard\Handling\ArrowKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\CharacterKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\EndKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\EnterKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\HomeKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\PageUpDownKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Keyboard;
use Mashbo\ConsoleToolkit\Tests\Doubles\InputStreamStub;

class KeyboardTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_calls_character_when_character_encountered()
    {
        $handler = $this->getMockBuilder(CharacterKeyHandler::class)->getMock();
        $handler
            ->expects($this->once())
            ->method('character')
            ->with($this->equalTo('a'))
        ;

        $sut = new Keyboard(InputStreamStub::withInput('a'), $handler);
        $sut->next();
    }

    /**
     * @dataProvider ansiCodeToMethodMappingDataProvider
     */
    public function test_it_calls_specific_chars_when_encountered($expectedInterface, $keyboardInput, $expectedMethod)
    {
        $handler = $this->getMockBuilder($expectedInterface)->getMock();
        $handler
            ->expects($this->once())
            ->method($expectedMethod)
            ->with()
        ;

        $sut = new Keyboard(InputStreamStub::withInput($keyboardInput), $handler);
        $sut->next();
    }

    public function test_it_calls_methods_sequentially_with_multiple_calls()
    {
        $handler = $this->getMockBuilder(CharacterKeyHandler::class)->getMock();
        $sut = new Keyboard(InputStreamStub::withInput('ab'), $handler);

        $handler
            ->expects($this->at(0))
            ->method('character')
            ->with($this->equalTo('a'))
        ;
        $handler
            ->expects($this->at(1))
            ->method('character')
            ->with($this->equalTo('b'))
        ;
        $sut->next();
        $sut->next();
    }

    public function test_it_keeps_a_stack_of_keyboard_handlers()
    {
        $handler1 = $this->getMockBuilder(CharacterKeyHandler::class)->getMock();
        $handler2 = $this->getMockBuilder(CharacterKeyHandler::class)->getMock();

        $handler1
            ->expects($this->at(0))
            ->method('character')
            ->with($this->equalTo('a'));

        $handler2
            ->expects($this->once())
            ->method('character')
            ->with($this->equalTo('b'));

        $handler1
            ->expects($this->at(1))
            ->method('character')
            ->with($this->equalTo('c'));

        $sut = new Keyboard(InputStreamStub::withInput('abc'), $handler1);
        $sut->next();
        $sut->pushHandler($handler2);
        $sut->next();
        $sut->resetHandler();
        $sut->next();

    }

    public function ansiCodeToMethodMappingDataProvider()
    {
        return [
            [EnterKeyHandler::class,        chr(13),           'enter'],
            [ArrowKeyHandler::class,        chr(27) . "[A",    'upArrow'],
            [ArrowKeyHandler::class,        chr(27) . "[B",    'downArrow'],
            [ArrowKeyHandler::class,        chr(27) . "[C",    'rightArrow'],
            [ArrowKeyHandler::class,        chr(27) . "[D",    'leftArrow'],
            [HomeKeyHandler::class,         chr(27) . "[H",    'home'],
            [EndKeyHandler::class,          chr(27) . "[F",    'end'],
            [PageUpDownKeyHandler::class,   chr(27) . "[5~",   'pageUp'],
            [PageUpDownKeyHandler::class,   chr(27) . "[6~",   'pageDown'],
        ];
    }
}
