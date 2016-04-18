<?php

namespace Mashbo\ConsoleToolkit\Widgets\RedrawableText;

use Mashbo\ConsoleToolkit\Terminal;

class RedrawableTextWriter
{
    /**
     * @var Terminal
     */
    private $terminal;

    private $currentValue = '';

    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function write($string)
    {
        $currentLength = strlen($this->currentValue);
        if ($currentLength > 0) {
            for ($i = 0; $i < $currentLength; $i++) {
                $this->terminal->write(chr(27) . "[1D");
                $this->terminal->write(" ");
                $this->terminal->write(chr(27) . "[1D");
            }
        }

        $this->currentValue = $string;
        $this->terminal->write($string);
    }
}