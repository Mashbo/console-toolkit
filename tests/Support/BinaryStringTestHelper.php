<?php

namespace Mashbo\ConsoleToolkit\Tests\Support;

final class BinaryStringTestHelper
{
    public static function assertEquals($expected, $actual)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            preg_replace('/[^\x09-\x0d\x20-\xff]/', '', str_replace([chr(27), "\n"], ['⎋', '\n'], $expected)),
            preg_replace('/[^\x09-\x0d\x20-\xff]/', '', str_replace([chr(27), "\n"], ['⎋', '\n'], $actual))
        );

        \PHPUnit_Framework_Assert::assertEquals($expected, $actual);
    }
}