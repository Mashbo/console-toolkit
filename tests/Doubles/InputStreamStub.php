<?php

namespace Mashbo\ConsoleToolkit\Tests\Doubles;

class InputStreamStub
{
    public static function withInput($initialInput)
    {
        $stream = fopen('php://memory', 'w');
        fwrite($stream, $initialInput);
        rewind($stream);
        return $stream;
    }
}
