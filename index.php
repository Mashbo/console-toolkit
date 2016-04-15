<?php

use Mashbo\ConsoleToolkit\ConsoleToolkit;
use Mashbo\ConsoleToolkit\Keyboard;
use Mashbo\ConsoleToolkit\KeyboardHandler;
use Mashbo\ConsoleToolkit\Terminal;
use Mashbo\ConsoleToolkit\Widgets\SingleChoiceQuestion\SingleChoiceQuestionFormatter;

require __DIR__.'/vendor/autoload.php';

class SingleChoiceQuestionHelper implements KeyboardHandler
{
    /**
     * @var Keyboard
     */
    private $keyboard;
    /**
     * @var Terminal
     */
    private $terminal;
    private $selectedChoiceIndex;
    private $choices;
    private $choiceMade = false;
    private $choicesStringLength = 0;
    /**
     * @var SingleChoiceQuestionFormatter
     */
    private $questionFormatter;

    public function __construct(Keyboard $keyboard, Terminal $terminal, SingleChoiceQuestionFormatter $questionFormatter)
    {
        $this->keyboard = $keyboard;
        $this->terminal = $terminal;
        $this->questionFormatter = $questionFormatter;
    }

    public function ask($question, $choices)
    {
        $this->keyboard->pushHandler($this);
        $this->terminal->write($question . "\n\n");

        $this->selectedChoiceIndex = 0;
        $this->choices = $choices;

        $this->updateChoice($this->selectedChoiceIndex);

        while (!$this->choiceMade) {
            $this->keyboard->next();
        }

        $this->keyboard->resetHandler();

        return $this->choices[$this->selectedChoiceIndex];

    }

    private function updateChoice($selectedIndex)
    {
        $choicesString = $this->questionFormatter->format($this->choices, $selectedIndex);
        $this->choicesStringLength = mb_strlen($choicesString);
        $this->terminal->write($choicesString);

    }

    public function character($char)
    {
    }

    public function leftArrow()
    {
    }

    public function rightArrow()
    {
    }

    public function upArrow()
    {
        $this->selectedChoiceIndex = $this->selectedChoiceIndex - 1;
        $this->selectedChoiceIndex = ($this->selectedChoiceIndex + count($this->choices)) % count($this->choices);

        $this->resetPositionForChoices();
        $this->updateChoice($this->selectedChoiceIndex);
    }

    public function downArrow()
    {
        $this->selectedChoiceIndex = $this->selectedChoiceIndex + 1;
        $this->selectedChoiceIndex = ($this->selectedChoiceIndex + count($this->choices)) % count($this->choices);

        $this->resetPositionForChoices();
        $this->updateChoice($this->selectedChoiceIndex);
    }

    public function home()
    {

    }

    public function end()
    {

    }

    public function pageUp()
    {

    }

    public function pageDown()
    {

    }

    public function backspace()
    {

    }

    public function tab()
    {

    }

    public function enter()
    {
        $this->choiceMade = true;
    }

    private function resetPositionForChoices()
    {
        $this->terminal->write(chr(27) . "[" . count($this->choices) . "A");

    }
}

class SingleLineTextValueHelper implements KeyboardHandler
{
    /**
     * @var Keyboard
     */
    private $keyboard;
    /**
     * @var Terminal
     */
    private $terminal;

    private $currentValue = '';
    private $ended = false;
    private $previousValueLength = 0;

    public function __construct(Keyboard $keyboard, Terminal $terminal)
    {
        $this->keyboard = $keyboard;
        $this->terminal = $terminal;
    }

    public function ask($question)
    {
        $this->terminal->write($question . " ");
        $this->keyboard->pushHandler($this);

        $this->currentValue = '';
        $this->previousValueLength = 0;

        while (!$this->ended) {
            $this->keyboard->next();
        }

        $this->keyboard->resetHandler();
        return $this->currentValue;
    }

    public function character($char)
    {
        $this->previousValueLength = strlen($this->currentValue);
        $this->currentValue .= $char;
        $this->redrawCurrentValue();
    }

    private function redrawCurrentValue()
    {
        if ($this->previousValueLength > 0) {
            for ($i = 0; $i < $this->previousValueLength; $i++) {
                $this->terminal->write(chr(27) . "[1D");
                $this->terminal->write(" ");
                $this->terminal->write(chr(27) . "[1D");
            }
        }
        $this->terminal->write($this->currentValue);
    }

    public function leftArrow() {}
    public function rightArrow() {}
    public function upArrow() {}

    public function downArrow() {}

    public function home() {}

    public function end() {}

    public function pageUp() {}

    public function pageDown() {}

    public function backspace()
    {
        $len = strlen($this->currentValue);
        $this->previousValueLength = $len;
        if ($len > 0) {
            $this->currentValue = substr($this->currentValue, 0, $len -1);
        }
        $this->redrawCurrentValue();
    }

    public function tab() {}

    public function enter()
    {
        $this->ended = true;
    }
}

ConsoleToolkit::disableDefaultBehaviour();
//$keyboard = new Keyboard(STDIN, new NullKeyboardHandler());

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


$singleLineTextValueHelper = new SingleLineTextValueHelper($keyboard, $terminal);
$singleLineTextValueHelper->ask('What\'s your project called?');
