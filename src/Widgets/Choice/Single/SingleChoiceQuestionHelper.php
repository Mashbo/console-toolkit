<?php

namespace Mashbo\ConsoleToolkit\Widgets\Choice\Single;

use Mashbo\ConsoleToolkit\Keyboard\Keyboard;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\Choice\ChoiceList;
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
        $choices = ChoiceList::fromAssocArray($choices);
        $this->terminal->write($question . "\n");

        $writer = new RedrawableTextWriter($this->terminal);
        $initialState = new SingleChoiceQuestionState($question, $choices);
        $writer->write($this->questionFormatter->format($initialState));

        return $this->keyboard->interact(
            new SingleChoiceQuestionKeyboardHandler(
                $this->keyboard,
                $this->questionFormatter,
                $writer,
                $initialState
            )
        );
    }

}