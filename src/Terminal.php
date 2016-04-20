<?php

namespace Mashbo\ConsoleToolkit;

use Mashbo\ConsoleToolkit\Exceptions\TerminalRequiresStreamException;
use Mashbo\ConsoleToolkit\Interaction\InteractionList;
use Mashbo\ConsoleToolkit\Keyboard\Handling\Handlers\NullKeyboardHandler;
use Mashbo\ConsoleToolkit\Keyboard\Keyboard;

class Terminal
{
    /**
     * @var resource
     */
    private $in;

    /**
     * @var resource
     */
    private $out;

    /**
     * @var Keyboard
     */
    private $keyboard;

    /**
     * @var InteractionList
     */
    private $interactionList;

    public function __construct($in, $out)
    {
        if (!is_resource($out) || 'stream' !== get_resource_type($out)) {
            throw new TerminalRequiresStreamException;
        }
        if (!is_resource($in) || 'stream' !== get_resource_type($in)) {
            throw new TerminalRequiresStreamException;
        }
        $this->out = $out;
        $this->in = $in;
        $this->keyboard = new Keyboard($this->in, new NullKeyboardHandler());

        $this->interactionList = new InteractionList($this);
    }

    /**
     * @return Keyboard
     */
    public function keyboard()
    {
        return $this->keyboard;
    }

    /**
     * @param string $string
     */
    public function write($string)
    {
        fwrite($this->out, $string);
    }

    /**
     * @return InteractionList
     */
    public function interaction()
    {
        return $this->interactionList;
    }
}
