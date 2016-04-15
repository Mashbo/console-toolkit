<?php

namespace Mashbo\ConsoleToolkit;

use Mashbo\ConsoleToolkit\Exceptions\TerminalRequiresStreamException;
use Mashbo\ConsoleToolkit\KeyboardHandlers\NullKeyboardHandler;

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

    public static function green($text)
    {
        return chr(27) . "[32m" . $text . chr(27) . "[0m";
    }
}
