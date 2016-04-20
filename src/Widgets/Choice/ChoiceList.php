<?php

namespace Mashbo\ConsoleToolkit\Widgets\Choice;

final class ChoiceList implements \IteratorAggregate, \Countable
{
    private $values;
    private $keys;

    public static function fromAssocArray(array $choices)
    {
        $list = new self;
        $list->values = array_values($choices);
        $list->keys = array_keys($choices);
        return $list;
    }

    public function firstIndex()
    {
        return $this->keys[0];
    }

    public function hasChoiceWithIndex($index)
    {
        return false !== array_search($index, $this->keys);
    }

    public function getIterator()
    {
        return new \ArrayIterator(array_combine($this->keys, $this->values));
    }

    public function count()
    {
        return count($this->keys);
    }

    public function previousIndex($currentIndex)
    {
        $position = array_search($currentIndex, $this->keys);
        $position--;
        $position = ($position + count($this->keys)) % count($this->keys);

        return $this->keys[$position];

    }

    public function nextIndex($currentIndex)
    {
        $position = array_search($currentIndex, $this->keys);
        $position++;
        $position = ($position + count($this->keys)) % count($this->keys);

        return $this->keys[$position];

    }
}
