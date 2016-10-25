<?php

namespace Mashbo\ConsoleToolkit\Tests\Unit\Ansi;

use Mashbo\ConsoleToolkit\Ansi\Ansi;

class AnsiTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider colourCodeToMethodNameDataProvider
     */
    public function test_text_can_be_wrapped_in_colour($code, $methodName)
    {
        $this->assertEquals(chr(27)."[{$code}mTest text" . chr(27)."[39m", Ansi::$methodName('Test text'));
    }

    public function test_backspace_is_returned()
    {
        $this->assertEquals(chr(27)."[1D", Ansi::backspace());
    }

    public function colourCodeToMethodNameDataProvider()
    {
        return [
            [30, 'black'],
            [31, 'red'],
            [32, 'green'],
            [33, 'yellow'],
            [34, 'blue'],
            [35, 'magenta'],
            [36, 'cyan'],
            [37, 'lightGray'],
            [90, 'darkGray'],
            [91, 'lightRed'],
            [92, 'lightGreen'],
            [93, 'lightYellow'],
            [94, 'lightBlue'],
            [95, 'lightMagenta'],
            [96, 'lightCyan'],
            [97, 'white'],
        ];
    }
}