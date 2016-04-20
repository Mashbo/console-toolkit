<?php

namespace Mashbo\ConsoleToolkit\Widgets\Choice\Single;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\Choice\ChoiceList;

class SingleChoiceQuestionFormatter
{
    public function format(SingleChoiceQuestionState $state)
    {
        $choicesString = '';
        foreach ($state->choices() as $index => $choice) {

            $selected = $state->indexIsSelected($index);
            $choicesString .= " ";

            $choicesString .= $selected
                ? Ansi::green("➜ $choice")
                : "○ $choice";
            $choicesString .= "\n";
        }

        return $choicesString;
    }
}
