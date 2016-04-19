<?php

namespace Mashbo\ConsoleToolkit\Widgets\Choice;

use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\Choice\Multiple\MultipleChoiceQuestionFormatter;
use Mashbo\ConsoleToolkit\Widgets\Choice\Multiple\MultipleChoiceQuestionHelper;
use Mashbo\ConsoleToolkit\Widgets\Choice\Single\SingleChoiceQuestionFormatter;
use Mashbo\ConsoleToolkit\Widgets\Choice\Single\SingleChoiceQuestionHelper;

class ChoiceWidgetBuilder
{
    /**
     * @var Terminal
     */
    private $terminal;

    private $multiple = false;

    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }
    public function single()
    {
        $this->multiple = false;
        return $this;
    }

    public function multiple()
    {
        $this->multiple = true;
        return $this;
    }

    public function build()
    {
        if ($this->multiple) {
            return new MultipleChoiceQuestionHelper(
                $this->terminal->keyboard(),
                $this->terminal,
                new MultipleChoiceQuestionFormatter()
            );
        }
        return new SingleChoiceQuestionHelper(
            $this->terminal->keyboard(),
            $this->terminal,
            new SingleChoiceQuestionFormatter()
        );
    }
}
