<?php

namespace Mashbo\ConsoleToolkit\Widgets\RedrawableText;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
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
        $lines = preg_split("/" . preg_quote("\n") . "/", $this->currentValue);
        if (count($lines) == 1) {
            $currentLength = strlen($this->currentValue);
            if ($currentLength > 0) {
                for ($i = 0; $i < $currentLength; $i++) {
                    $this->terminal->write(Ansi::backspace());
                    $this->terminal->write(" ");
                    $this->terminal->write(Ansi::backspace());
                }
            }

        } else {
            $this->terminal->write(Ansi::cursorToStartOfLine());
            $this->terminal->write(Ansi::eraseToEndOfLine());

            for ($i = count($lines) - 1; $i > 0; $i--) {
                $this->terminal->write(Ansi::cursorUp());
                $this->terminal->write(Ansi::eraseToEndOfLine());
            }
        }

        $this->currentValue = $string;
        $this->terminal->write($string);
    }
}