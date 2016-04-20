<?php

namespace Mashbo\ConsoleToolkit\Widgets\Choice\Multiple;

use Mashbo\ConsoleToolkit\Keyboard\Handling\ArrowKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\EnterKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Keyboard;
use Mashbo\ConsoleToolkit\Keyboard\Handling\CharacterKeyHandler;
use Mashbo\ConsoleToolkit\Widgets\Choice\Multiple\MultipleChoiceQuestionFormatter;
use Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextWriter;

class MultipleChoiceQuestionKeyboardHandler implements CharacterKeyHandler, ArrowKeyHandler, EnterKeyHandler
{
    /**
     * @var
     */
    private $question;
    /**
     * @var
     */
    private $choices;

    private $currentPosition = 0;

    private $selectedChoicesIndicies;
    /**
     * @var MultipleChoiceQuestionFormatter
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

    public function __construct(Keyboard $keyboard, MultipleChoiceQuestionFormatter $questionFormatter, RedrawableTextWriter $writer, $question, $choices)
    {
        $this->question = $question;
        $this->choices = $choices;
        $this->selectedChoicesIndicies = [];

        $this->questionFormatter = $questionFormatter;
        $this->writer = $writer;
        $this->keyboard = $keyboard;
    }

    public function character($char) {
        if (' ' == $char) {
            if (!array_key_exists($this->currentPosition, $this->selectedChoicesIndicies)) {
                $this->selectedChoicesIndicies[$this->currentPosition] = false;
            }

            $this->selectedChoicesIndicies[$this->currentPosition] = ! $this->selectedChoicesIndicies[$this->currentPosition];
        }
        $this->updateChoice();
    }
    public function leftArrow() {}
    public function rightArrow() {}
    
    public function upArrow()
    {
        $this->currentPosition = $this->currentPosition - 1;
        $this->currentPosition = ($this->currentPosition + count($this->choices)) % count($this->choices);

        $this->updateChoice();
    }

    public function downArrow()
    {
        $this->currentPosition = $this->currentPosition + 1;
        $this->currentPosition = ($this->currentPosition + count($this->choices)) % count($this->choices);

        $this->updateChoice();
    }


    private function updateChoice()
    {
        $selectedChoiceIndicies = [];
        foreach ($this->selectedChoicesIndicies as $index => $selected) {
            if ($selected) {
                $selectedChoiceIndicies[] = $index;
            }
        }
        $this->writer->write(
            $this->questionFormatter->format(
                $this->choices,
                $selectedChoiceIndicies,
                $this->currentPosition
            )
        );
    }

    public function enter()
    {
        $this->keyboard->stopInteraction($this->getCurrentlySelectedChoices());
    }

    /**
     * @return array
     */
    private function getCurrentlySelectedChoices()
    {
        $choices = [];
        foreach ($this->selectedChoicesIndicies as $index => $selected) {
            if ($selected) {
                $choices[$index] = $this->choices[$index];
            }
        }
        return array_values($choices);
    }
}
