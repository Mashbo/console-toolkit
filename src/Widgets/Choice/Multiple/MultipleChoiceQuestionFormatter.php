<?php

namespace Mashbo\ConsoleToolkit\Widgets\Choice\Multiple;

use Mashbo\ConsoleToolkit\Ansi\Ansi;

class MultipleChoiceQuestionFormatter
{
    public function format(array $choices, array $selectedIndicies, $currentPosition)
    {
        $choicesString = '';
        foreach ($choices as $index => $choice) {

            $selected = in_array($index, $selectedIndicies, true);
            $choicesString .= " ";

            $colouredChoiceString = $selected
                ? Ansi::green("● $choice")
                : "○ $choice";
            $highlightedChoiceString = ($currentPosition == $index)
                ? Ansi::bold($colouredChoiceString)
                : $colouredChoiceString;

            $choicesString .= $highlightedChoiceString;

            $choicesString .= "\n";
        }

        return $choicesString;
    }
}
