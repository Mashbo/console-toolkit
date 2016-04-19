<?php

namespace Mashbo\ConsoleToolkit\Widgets\Choice\Single;

use Mashbo\ConsoleToolkit\Ansi\Ansi;
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
                ? Ansi::green("➜ $choice")
                : "○ $choice";
            $choicesString .= "\n";
        }

        return $choicesString;
    }
}
