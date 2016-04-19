<?php

use Mashbo\ConsoleToolkit\Ansi\Ansi;
use Mashbo\ConsoleToolkit\ConsoleToolkit;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\Choice\Multiple\MultipleChoiceQuestionFormatter;
use Mashbo\ConsoleToolkit\Widgets\Choice\Multiple\MultipleChoiceQuestionHelper;
use Mashbo\ConsoleToolkit\Widgets\Text\TextQuestionHelper;

require __DIR__ . '/vendor/autoload.php';


ConsoleToolkit::disableDefaultBehaviour();

$terminal = new Terminal(STDIN, STDOUT);
$keyboard = $terminal->keyboard();

//echo Ansi::green('green');
//echo Ansi::bold('bold');
//echo Ansi::bold(Ansi::green('boldgreen'));
//echo 'std';
//echo Ansi::green(Ansi::bold('greenbold'));
//echo 'std';
//exit;


//$singleChoiceQuestionHelper = new SingleChoiceQuestionHelper($keyboard, $terminal, new SingleChoiceQuestionFormatter());
//
//$seed = $singleChoiceQuestionHelper->ask('What type of project would you like to create?', ['Default', 'Symfony', 'Wordpress', 'Magento']);
//$terminal->write("You chose $seed\n\n");

$multipleChoiceQuestionHelper = new MultipleChoiceQuestionHelper($keyboard, $terminal, new MultipleChoiceQuestionFormatter());

$services = $multipleChoiceQuestionHelper->ask('Services to enable', ['Web (80)', 'SSH (22)', 'FTP (21)']);
$terminal->write("You chose " . implode(', ', $services) . "\n\n");


$singleLineTextValueHelper = new TextQuestionHelper($keyboard, $terminal);
$terminal->write("\nYou chose: " . $singleLineTextValueHelper->ask('What\'s your project called?') . "\n");
