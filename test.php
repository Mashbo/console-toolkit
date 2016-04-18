<?php

use Mashbo\ConsoleToolkit\ConsoleToolkit;
use Mashbo\ConsoleToolkit\Terminal;

require __DIR__ . '/vendor/autoload.php';


ConsoleToolkit::disableDefaultBehaviour();

$terminal = new Terminal(STDIN, STDOUT);
$keyboard = $terminal->keyboard();

$writer = new \Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextWriter($terminal);

$writer->write("hello\nworld");
sleep(1);
$writer->write("hola\nmondo");
