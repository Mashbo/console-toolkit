<?php

namespace Mashbo\ConsoleToolkit\Tests\Doubles;

use Mashbo\ConsoleToolkit\Tests\Support\BinaryStringTestHelper;

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
        
        BinaryStringTestHelper::assertEquals($expected, $actual);
    }
}
