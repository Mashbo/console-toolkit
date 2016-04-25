<?php

namespace Mashbo\ConsoleToolkit\Tests\Functional\ArgumentHandling;

use Mashbo\ConsoleToolkit\Arguments\ArgumentList;
use Mashbo\ConsoleToolkit\Arguments\UnixStyleArgumentDataMapper;

class SingleCommandScriptTest extends \PHPUnit_Framework_TestCase
{
    public function test_positional_arguments_can_be_mapped()
    {
        $mapper = new UnixStyleArgumentDataMapper(['first', 'second']);
        $expected = [
            'first'     => '1',
            'second'    => '2'
        ];
        $this->assertSame($expected, $mapper->resolve(ArgumentList::fromArgv(['script', '1', '2'])));
    }

    public function test_named_arguments_can_be_mapped()
    {
        $mapper = new UnixStyleArgumentDataMapper(['first' => 'number1', 'second' => 'number2']);
        $expected = [
            'number1'   => '1',
            'number2'   => '2'
        ];
        $this->assertSame($expected, $mapper->resolve(ArgumentList::fromArgv(['script', '--first=1', '--second=2'])));
    }
}
