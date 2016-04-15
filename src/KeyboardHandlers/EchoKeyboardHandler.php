<?php

namespace Mashbo\ConsoleToolkit\KeyboardHandlers;

class EchoKeyboardHandler extends NullKeyboardHandler
{
    /**
     * @var
     */
    private $stream;

    public function __construct($stream)
    {
        $this->stream = $stream;
    }

    public function character($char)
    {
        $this->write($char);
    }

    /**
     * @param $string
     */
    private function write($string)
    {
        fwrite($this->stream, $string);
        fflush($this->stream);
    }
}