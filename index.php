<?php

use Mashbo\ConsoleToolkit\ConsoleToolkit;
use Mashbo\ConsoleToolkit\Keyboard;
use Mashbo\ConsoleToolkit\KeyboardHandler;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextKeyboardHandler;
use Mashbo\ConsoleToolkit\Widgets\RedrawableText\RedrawableTextWriter;
use Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion\SingleChoiceQuestionFormatter;
use Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion\SingleChoiceQuestionHelper;
use Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion\SingleChoiceQuestionKeyboardHandler;
use Mashbo\ConsoleToolkit\Widgets\Text\TextQuestionHelper;

require __DIR__.'/vendor/autoload.php';


ConsoleToolkit::disableDefaultBehaviour();

$terminal = new Terminal(STDIN, STDOUT);
$keyboard = $terminal->keyboard();


$singleChoiceQuestionHelper = new SingleChoiceQuestionHelper($keyboard, $terminal, new SingleChoiceQuestionFormatter());

$header = <<<HEADER
 __  __           _     _           _       
|  \/  | __ _ ___| |__ | |__   ___ | |_     
| |\/| |/ _` / __| '_ \| '_ \ / _ \| __|    
| |  | | (_| \__ \ | | | |_) | (_) | |_   _ 
|_|  |_|\__,_|___/_| |_|_.__/ \___/ \__| (_)


HEADER;

$terminal->write($header);
$seed = $singleChoiceQuestionHelper->ask('What type of project would you like to create?', ['Default', 'Symfony', 'Wordpress', 'Magento']);
$terminal->write("You chose $seed\n\n");


$singleLineTextValueHelper = new TextQuestionHelper($keyboard, $terminal);
$terminal->write("\nYou chose: " . $singleLineTextValueHelper->ask('What\'s your project called?') . "\n");
