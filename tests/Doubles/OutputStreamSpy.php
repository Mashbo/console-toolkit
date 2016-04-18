<?php

namespace Mashbo\ConsoleToolkit\Tests\Doubles;

class OutputStreamSpy
{
    public static function create()
    {
        $stream = fopen('php://memory', 'w');
        return $stream;
    }

    public static function assertWrittenContents($stream, $expected)
    {
        rewind($stream);
        $actual = '';
        while (false !== ($nextLine = fgets($stream))) {
            $actual .= $nextLine;
        }
        
        \PHPUnit_Framework_Assert::assertEquals($expected, $actual);
    }
}
