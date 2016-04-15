<?php

namespace Mashbo\ConsoleToolkit;

final class ConsoleToolkit
{
    private function __construct() {}

    public static function disableDefaultBehaviour()
    {
        readline_callback_handler_install('', function() {});
    }

    public static function resetDefaultBehaviour()
    {
        readline_callback_handler_remove();
    }
}
