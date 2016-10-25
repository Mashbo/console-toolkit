<?php

namespace Mashbo\ConsoleToolkit\Ansi;

final class Ansi
{
    private static $fgColours = [
        'black'         => 30,
        'red'           => 31,
        'green'         => 32,
        'yellow'        => 33,
        'blue'          => 34,
        'magenta'       => 35,
        'cyan'          => 36,
        'lightGray'     => 37,
        'darkGray'      => 90,
        'lightRed'      => 91,
        'lightGreen'    => 92,
        'lightYellow'   => 93,
        'lightBlue'     => 94,
        'lightMagenta'  => 95,
        'lightCyan'     => 96,
        'white'         => 97
    ];

    public static function backspace()
    {
        return "\e[1D";
    }

    public static function green($text)
    {
        return self::changeForegroundColour($text, self::$fgColours[__FUNCTION__]);
    }

    public static function white($text)
    {
        return self::changeForegroundColour($text, self::$fgColours[__FUNCTION__]);
    }


    public static function red($text)
    {
        return self::changeForegroundColour($text, self::$fgColours[__FUNCTION__]);
    }

    public static function lightRed($text)
    {
        return self::changeForegroundColour($text, self::$fgColours[__FUNCTION__]);
    }

    public static function yellow($text)
    {
        return self::changeForegroundColour($text, self::$fgColours[__FUNCTION__]);
    }

    public static function blue($text)
    {
        return self::changeForegroundColour($text, self::$fgColours[__FUNCTION__]);
    }

    public static function lightBlue($text)
    {
        return self::changeForegroundColour($text, self::$fgColours[__FUNCTION__]);
    }

    public static function lightYellow($text)
    {
        return self::changeForegroundColour($text, self::$fgColours[__FUNCTION__]);
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

    public static function bold($text)
    {
        return "\e[1m$text\e[22m";
    }

    /**
     * @param $text
     * @param $code
     * @return string
     */
    private static function changeForegroundColour($text, $code)
    {
        return "\e[{$code}m$text\e[39m";
    }
}