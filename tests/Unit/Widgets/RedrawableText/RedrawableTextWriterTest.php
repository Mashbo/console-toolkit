<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Widgets\RedrawableText;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Tests\Doubles\InputStreamStub;
use Mashbo\ConsoleToolkit\Tests\Doubles\OutputStreamSpy;
use Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextWriter;

class RedrawableTextWriterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var resource
     */
    private $out;

    /**
     * @var RedrawableTextWriter
     */
    private $sut;

    public function setUp()
    {
        $this->out = OutputStreamSpy::create();
        $this->sut = new RedrawableTextWriter(
            new Terminal(InputStreamStub::withInput(''), $this->out)
        );
    }

    public function test_it_writes_output_to_terminal()
    {
        $this->sut->write("Hello");
        OutputStreamSpy::assertWrittenContents($this->out, 'Hello');

    }

    public function test_it_overwrites_previous_output()
    {
        $this->sut->write("Hello");
        OutputStreamSpy::assertWrittenContents($this->out, 'Hello');

        $this->sut->write("World");
        OutputStreamSpy::assertWrittenContents(
            $this->out,
            'Hello' .
            str_repeat(Ansi::backspace() . " " . Ansi::backspace(), 5) .
            "World"
        );
    }

    public function test_it_deals_with_two_lines()
    {
        $this->sut->write("this is a\nmultiline string");
        $this->sut->write("another string");

        OutputStreamSpy::assertWrittenContents(
            $this->out,
            "this is a\nmultiline string" .
            Ansi::cursorToStartOfLine() . Ansi::eraseToEndOfLine() .
            Ansi::cursorUp() .
            Ansi::eraseToEndOfLine() .
            "another string"
        );
    }
}