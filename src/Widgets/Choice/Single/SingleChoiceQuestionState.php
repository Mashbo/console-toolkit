<?php

namespace Mashbo\ConsoleToolkit\Widgets\Choice\Single;

use Mashbo\ConsoleToolkit\Widgets\Choice\ChoiceList;

class SingleChoiceQuestionState
{
    /**
     * @var ChoiceList
     */
    private $choices;

    /**
     * @var int|string
     */
    private $selectedChoiceIndex;

    public function __construct($question, ChoiceList $choices, $selectedChoiceIndex = null)
    {
        $this->choices = $choices;
        $this->select(
            is_null($selectedChoiceIndex)
                ? $choices->firstIndex()
                : $selectedChoiceIndex
        );
    }

    public function indexIsSelected($index)
    {
        return $this->selectedChoiceIndex == $index;
    }

    /**
     * @return int|string
     */
    public function selectedIndex()
    {
        return $this->selectedChoiceIndex;
    }

    /**
     * @return ChoiceList
     */
    public function choices()
    {
        return $this->choices;
    }

    public function upArrow()
    {
        $this->selectedChoiceIndex = $this->choices->previousIndex($this->selectedChoiceIndex);
    }

    public function downArrow()
    {
        $this->selectedChoiceIndex = $this->choices->nextIndex($this->selectedChoiceIndex);
    }

    private function select($currentlyFocusedIndex)
    {
        if (!$this->choices->hasChoiceWithIndex($currentlyFocusedIndex)) {
            throw new \LogicException("Cannot select index $currentlyFocusedIndex");
        }
        $this->selectedChoiceIndex = $currentlyFocusedIndex;
    }
}