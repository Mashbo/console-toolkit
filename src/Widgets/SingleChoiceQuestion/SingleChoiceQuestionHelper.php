<?php

namespace Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion;

use Mashbo\ConsoleToolkit\Keyboard;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextWriter;

class SingleChoiceQuestionHelper
{
    /**
     * @var Keyboard
     */
    private $keyboard;
    /**
     * @var Terminal
     */
    private $terminal;

    /**
     * @var SingleChoiceQuestionFormatter
     */
    private $questionFormatter;

    public function __construct(Keyboard $keyboard, Terminal $terminal, SingleChoiceQuestionFormatter $questionFormatter)
    {
        $this->keyboard = $keyboard;
        $this->terminal = $terminal;
        $this->questionFormatter = $questionFormatter;
    }

    public function ask($question, $choices)
    {
        $this->terminal->write($question . "\n");

        $writer = new RedrawableTextWriter($this->terminal);
        $writer->write($this->questionFormatter->format($choices, 0));

        return $this->keyboard->interact(
            new SingleChoiceQuestionKeyboardHandler(
                $this->keyboard,
                $this->questionFormatter,
                $writer,
                $question,
                $choices
            )
        );
    }

}