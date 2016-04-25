<?php

namespace Mashbo\ConsoleToolkit\Arguments;

interface ArgumentDataMapper
{
    /**
     * @return array
     */
    public function resolve(ArgumentList $list);
}
