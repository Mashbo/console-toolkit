<?php

namespace Mashbo\ConsoleToolkit\Interaction;

use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\Choice\ChoiceWidgetBuilder;

final class InteractionList
{
    /**
     * @var Terminal
     */
    private $terminal;

    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }
    /**
     * @return ChoiceWidgetBuilder
     */
    public function choice()
    {
        return new ChoiceWidgetBuilder($this->terminal);
    }
}
