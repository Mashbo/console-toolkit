<?php

namespace Mashbo\ConsoleToolkit\Arguments;

final class ArgumentList implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $arguments;

    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public static function fromArgv($argv)
    {
        array_shift($argv);
        return new self($argv);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->arguments);
    }
}
