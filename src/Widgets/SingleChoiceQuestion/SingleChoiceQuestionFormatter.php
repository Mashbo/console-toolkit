<?php

namespace Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion;

use Mashbo\ConsoleToolkit\Terminal;

class SingleChoiceQuestionFormatter
{
    public function format(array $choices, $selectedIndex)
    {
        $choicesString = '';
        foreach ($choices as $index => $choice) {

            $selected = $index == $selectedIndex;
            $choicesString .= " ";

            $choicesString .= $selected
                ? chr(27) . "[32m" . '➜'
                : '○';
            $choicesString .= " " . $choice;
            $choicesString .= $selected ? chr(27) . "[0m" : '';
            $choicesString .= "\n";
        }

        return $choicesString;
    }
}
