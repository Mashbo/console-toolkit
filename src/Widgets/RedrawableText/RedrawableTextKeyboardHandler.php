<?php

namespace Mashbo\ConsoleToolkit\Widgets\RedrawableText;


use Mashbo\ConsoleToolkit\Keyboard\Handling\BackspaceKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\CharacterKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\EnterKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Keyboard;

class RedrawableTextKeyboardHandler implements CharacterKeyHandler, BackspaceKeyHandler, EnterKeyHandler
{
    private $currentValue = '';
    private $previousValueLength = 0;
    /**
     * @var RedrawableTextWriter
     */
    private $writer;
    /**
     * @var Keyboard
     */
    private $keyboard;

    public function __construct(RedrawableTextWriter $writer, Keyboard $keyboard)
    {
        $this->writer = $writer;
        $this->keyboard = $keyboard;
    }


    public function character($char)
    {
        $this->currentValue .= $char;
        $this->writer->write($this->currentValue);
    }


    public function leftArrow() {}
    public function rightArrow() {}
    public function upArrow() {}

    public function downArrow() {}

    public function home() {}

    public function end() {}

    public function pageUp() {}

    public function pageDown() {}

    public function backspace()
    {
        $len = strlen($this->currentValue);
        $this->previousValueLength = $len;
        if ($len > 0) {
            $this->currentValue = substr($this->currentValue, 0, $len - 1);
        }
        $this->writer->write($this->currentValue);
    }

    public function tab() {}

    public function enter()
    {
        $this->keyboard->stopInteraction($this->currentValue);
    }

    /**
     * @return string
     */
    public function getCurrentValue()
    {
        return $this->currentValue;
    }
}