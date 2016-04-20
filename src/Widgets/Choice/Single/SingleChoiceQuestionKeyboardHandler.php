<?php

namespace Mashbo\ConsoleToolkit\Widgets\Choice\Single;

use Mashbo\ConsoleToolkit\Keyboard\Handling\ArrowKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\CharacterKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\EnterKeyHandler;
use Mashbo\ConsoleToolkit\Keyboard\Handling\KeyboardHandler;
use Mashbo\ConsoleToolkit\Keyboard\Keyboard;
use Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextWriter;

class SingleChoiceQuestionKeyboardHandler implements ArrowKeyHandler, EnterKeyHandler
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
    /**
     * @var SingleChoiceQuestionState
     */
    private $state;

    public function __construct(Keyboard $keyboard, SingleChoiceQuestionFormatter $questionFormatter, RedrawableTextWriter $writer, SingleChoiceQuestionState $state)
    {
        $this->questionFormatter = $questionFormatter;
        $this->writer = $writer;
        $this->keyboard = $keyboard;
        $this->state = $state;
    }

    public function character($char) {}
    public function leftArrow() {}
    public function rightArrow() {}

    public function upArrow()
    {
        $this->state->upArrow();

        $this->updateChoice();
    }

    public function downArrow()
    {
        $this->state->downArrow();

        $this->updateChoice();
    }


    private function updateChoice()
    {
        $this->writer->write(
            $this->questionFormatter->format($this->state)
        );
    }

    public function enter()
    {
        $this->keyboard->stopInteraction($this->state->selectedIndex());
    }
}
