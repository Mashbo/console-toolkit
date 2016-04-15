<?php

namespace Mashbo\ConsoleToolkit\Exceptions;

class TerminalRequiresStreamException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("A terminal class must be instantiated with a stream resource");
    }
}
