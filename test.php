<?php

use Mashbo\ConsoleToolkit\Arguments\ArgumentList;
use Mashbo\ConsoleToolkit\Arguments\UnixStyleArgumentDataMapper;
use Mashbo\ConsoleToolkit\ConsoleToolkit;
use Mashbo\ConsoleToolkit\Terminal;

require __DIR__ . '/vendor/autoload.php';

ConsoleToolkit::disableDefaultBehaviour();

$terminal = new Terminal(STDIN, STDOUT);
$keyboard = $terminal->keyboard();

$input = new \Webmozart\Console\Args\ArgvArgs($_SERVER['argv']);

$mapper = new UnixStyleArgumentDataMapper([
    0   => 'a',
    1   => 'b',
    2   => 'c',
    'd' => 'myData'
]);
$data = $mapper->resolve(ArgumentList::fromArgv($_SERVER['argv']));
var_dump($data);

//var_dump($input->getTokens());

// git add -p
// git checkout -- add -p

//$mapper = new

// ./command arg1 arg2
//$mapper = new SingleCommandArgumentDataMapper();
//
// ./git add -p
//$mapper = new SubCommandArgumentDataMapper('add');

//var_dump($_SERVER['argv']);
