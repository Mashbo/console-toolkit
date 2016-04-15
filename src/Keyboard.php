<?php

namespace Mashbo\ConsoleToolkit;

class Keyboard
{
    private $stream;

    /**
     * @var KeyboardHandler[]
     */
    private $handlers;

    public function __construct($stream, KeyboardHandler $handler)
    {
        $this->stream = $stream;
        $this->handlers = [$handler];
    }

    /**
     * @param KeyboardHandler $handler
     */
    public function pushHandler(KeyboardHandler $handler)
    {
        array_push($this->handlers, $handler);
    }

    private function handler()
    {
        return $this->handlers[count($this->handlers) - 1];
    }

    public function resetHandler()
    {
        array_pop($this->handlers);
    }

    public function next()
    {
        $multibyteChars = [
            chr(27) => [
                chr(91) => [
                    "A" => 'upArrow',
                    "B" => 'downArrow',
                    "C" => 'rightArrow',
                    "D" => 'leftArrow',
                    "H" => 'home',
                    "F" => 'end',
                    "5" => ["~" => 'pageUp'],
                    "6" => ["~" => 'pageDown']
                ]
            ],
            chr(127)    => 'backspace',
            chr(9)      => 'tab',
            chr(10)     => 'enter'
        ];

        $mapping = $multibyteChars;
        $readFromStream = "";
        do {
            $c = stream_get_contents($this->stream, 1);

            $readFromStream .= $c;

            if (array_key_exists($c, $mapping)) {

                if (is_string($mapping[$c])) {
                    $method = $mapping[$c];
                    $this->handler()->$method();
                    break;
                } elseif (is_array($mapping[$c])) {
                    $mapping = $mapping[$c];
                    continue;
                } else {
                    throw new \LogicException("Array key set, but found neither string nor array");
                }
            }

            $this->handler()->character($readFromStream);
            break;

        } while (true);
    }
}
