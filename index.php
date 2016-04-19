<?php

use Mashbo\ConsoleToolkit\ConsoleToolkit;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion\SingleChoiceQuestionFormatter;
use Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion\SingleChoiceQuestionHelper;
use Mashbo\ConsoleToolkit\Widgets\Text\TextQuestionHelper;

require __DIR__ . '/vendor/autoload.php';


ConsoleToolkit::disableDefaultBehaviour();

$terminal = new Terminal(STDIN, STDOUT);
$keyboard = $terminal->keyboard();


$singleChoiceQuestionHelper = new SingleChoiceQuestionHelper($keyboard, $terminal, new SingleChoiceQuestionFormatter());

$seed = $singleChoiceQuestionHelper->ask('What type of project would you like to create?', ['Default', 'Symfony', 'Wordpress', 'Magento']);
$terminal->write("You chose $seed\n\n");


$singleLineTextValueHelper = new TextQuestionHelper($keyboard, $terminal);
$terminal->write("\nYou chose: " . $singleLineTextValueHelper->ask('What\'s your project called?') . "\n");
