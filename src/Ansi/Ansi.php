<?php

namespace Mashbo\ConsoleToolkit\Ansi;

final class Ansi
{
    public static function backspace()
    {
        return "\e[1D";
    }

    public static function green($text)
    {
        return "\e[32m$text\e[0m";
    }

    public static function cursorUp()
    {
        return "\e[A";
    }

    public static function eraseToEndOfLine()
    {
        return "\e[0K";
    }

    public static function cursorToStartOfLine()
    {
        return "\e[0G";
    }
}