<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Ansi;

use Mashbo\ConsoleToolkit\Ansi\Ansi;

class AnsiTest extends \PHPUnit_Framework_TestCase
{

    public function test_text_can_be_wrapped_in_green()
    {
        $this->assertEquals(chr(27)."[32mTest text" . chr(27)."[0m", Ansi::green('Test text'));
    }

    public function test_backspace_is_returned()
    {
        $this->assertEquals(chr(27)."[1D", Ansi::backspace());
    }
}