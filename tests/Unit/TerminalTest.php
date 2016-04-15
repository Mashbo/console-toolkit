<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit;

use Mashbo\ConsoleToolkit\Exceptions\TerminalRequiresStreamException;
use Mashbo\ConsoleToolkit\Keyboard;
use Mashbo\ConsoleToolkit\KeyboardHandlers\EchoKeyboardHandler;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Tests\Doubles\InputStreamStub;

class TerminalTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_can_write_to_stream()
    {
        $out = $this->writableMemoryStream();

        $sut = new Terminal($this->nullInputStream(), $out);
        $sut->write('hello');
        rewind($out);
        $this->assertEquals('hello', fgets($out));
    }

    /**
     * @dataProvider invalidStreamsDataProvider
     */
    public function test_it_throws_exception_if_not_constructed_with_valid_input_stream($stream)
    {
        $this->expectException(TerminalRequiresStreamException::class);
        new Terminal($stream, $this->nullInputStream());
    }

    /**
     * @dataProvider invalidStreamsDataProvider
     */
    public function test_it_throws_exception_if_not_constructed_with_valid_output_stream($stream)
    {
        $this->expectException(TerminalRequiresStreamException::class);
        new Terminal($this->nullInputStream(), $stream);
    }

    public function test_it_returns_same_keyboard_each_time_called()
    {
        $sut = new Terminal(InputStreamStub::withInput(''), $this->writableMemoryStream());

        $keyboard = $sut->keyboard();
        $keyboard2 = $sut->keyboard();

        $this->assertInstanceOf(Keyboard::class, $keyboard);
        $this->assertSame($keyboard, $keyboard2);
    }

    /**
     * @depends test_it_returns_same_keyboard_each_time_called
     */
    public function test_keyboard_wraps_around_input_stream()
    {
        $out = $this->writableMemoryStream();

        $sut = new Terminal(InputStreamStub::withInput('abcd'), $out);


        $keyboard = $sut->keyboard();
        $keyboard->pushHandler(new EchoKeyboardHandler($out));
        $keyboard->next();
        $keyboard->next();

        rewind($out);
        $this->assertEquals('ab', fgets($out));

    }

    /**
     * @dataProvider validStreamsDataProvider
     */
    public function test_it_accepts_valid_streams($stream)
    {
        new Terminal($this->nullInputStream(), $stream);
    }

    public function invalidStreamsDataProvider()
    {
        return [
            ['a'],
            [1],
            [new \stdClass()],
            [true]
        ];
    }
    public function validStreamsDataProvider()
    {
        return [
            [STDIN],
            [STDOUT],
            [fopen('php://memory', 'r')],
        ];
    }

    /**
     * @return mixed
     */
    private function nullInputStream()
    {
        return fopen('file:///dev/null', 'r');
    }

    /**
     * @return mixed
     */
    private function writableMemoryStream()
    {
        return fopen('php://memory', 'w');
    }
}
