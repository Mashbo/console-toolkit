<?php

namespace Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion;

use Mashbo\ConsoleToolkit\Keyboard;
use Mashbo\ConsoleToolkit\KeyboardHandler;
use Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextWriter;

class SingleChoiceQuestionKeyboardHandler implements KeyboardHandler
{
    /**
     * @var
     */
    private $question;
    /**
     * @var
     */
    private $choices;
    private $selectedChoiceIndex;
    /**
     * @var SingleChoiceQuestionFormatter
     */
    private $questionFormatter;
    /**
     * @var RedrawableTextWriter
     */
    private $writer;
    /**
     * @var Keyboard
     */
    private $keyboard;

    public function __construct(Keyboard $keyboard, SingleChoiceQuestionFormatter $questionFormatter, RedrawableTextWriter $writer, $question, $choices)
    {
        $this->question = $question;
        $this->choices = $choices;
        $this->selectedChoiceIndex = 0;

        $this->questionFormatter = $questionFormatter;
        $this->writer = $writer;
        $this->keyboard = $keyboard;
    }

    public function character($char) {}
    public function leftArrow() {}
    public function rightArrow() {}
    public function home() {}
    public function end() {}
    public function pageUp() {}
    public function pageDown() {}
    public function backspace() {}
    public function tab() {}

    
    public function upArrow()
    {
        $this->selectedChoiceIndex = $this->selectedChoiceIndex - 1;
        $this->selectedChoiceIndex = ($this->selectedChoiceIndex + count($this->choices)) % count($this->choices);

        $this->updateChoice();
    }

    public function downArrow()
    {
        $this->selectedChoiceIndex = $this->selectedChoiceIndex + 1;
        $this->selectedChoiceIndex = ($this->selectedChoiceIndex + count($this->choices)) % count($this->choices);

        $this->updateChoice();
    }


    private function updateChoice()
    {
        $this->writer->write(
            $this->questionFormatter->format($this->choices, $this->selectedChoiceIndex)
        );
    }

    public function enter()
    {
        $this->keyboard->stopInteraction($this->choices[$this->selectedChoiceIndex]);
    }
}
