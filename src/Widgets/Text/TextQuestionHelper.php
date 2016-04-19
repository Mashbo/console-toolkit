<?php

namespace Mashbo\ConsoleToolkit\Widgets\Text;

use Mashbo\ConsoleToolkit\Keyboard;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextKeyboardHandler;
use Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextWriter;

class TextQuestionHelper
{
    /**
     * @var Keyboard
     */
    private $keyboard;
    /**
     * @var Terminal
     */
    private $terminal;

    public function __construct(Keyboard $keyboard, Terminal $terminal)
    {
        $this->keyboard = $keyboard;
        $this->terminal = $terminal;
    }

    public function ask($question)
    {
        $this->terminal->write($question . " ");

        $response = $this->keyboard->interact(
            new RedrawableTextKeyboardHandler(
                new RedrawableTextWriter($this->terminal),
                $this->keyboard
            )
        );

        $this->terminal->write("\n");

        return $response;
    }
}
