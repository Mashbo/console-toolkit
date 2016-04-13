<?php

require __DIR__.'/vendor/autoload.php';

//$input = new \Symfony\Component\Console\Input\ArgvInput();
$output = new \Symfony\Component\Console\Output\StreamOutput(STDOUT);

//$output->writeln(['a', 'b']);


class Keyboard
{
    private $stream;

    /**
     * @var KeyboardHandler[]
     */
    private $handlers;

    public function __construct($stream, KeyboardHandler $handler)
    {
        $this->stream = $stream;
        $this->handlers = [$handler];
    }

    /**
     * @param KeyboardHandler $handler
     */
    public function setHandler(KeyboardHandler $handler)
    {
        array_push($this->handlers, $handler);
    }

    private function handler()
    {
        return $this->handlers[count($this->handlers) - 1];
    }

    public function resetHandler()
    {
        array_pop($this->handlers);
    }

    public function next()
    {
        $multibyteChars = [
            chr(27) => [
                chr(91) => [
                    "A" => 'upArrow',
                    "B" => 'downArrow',
                    "C" => 'rightArrow',
                    "D" => 'leftArrow',
                    "H" => 'home',
                    "F" => 'end',
                    "5" => 'pageUp',
                    "6" => [chr(126) => 'pageDown']
                ]
            ],
            chr(127)    => 'backspace',
            chr(9)      => 'tab',
            chr(10)     => 'enter'
        ];

        $mapping = $multibyteChars;
        $readFromStream = "";
        do {
            $c = stream_get_contents($this->stream, 1);
//            exec("say -r 300 \"" . ord($c) . " or " . ((strtoupper($c) === $c) ? ' capital ' : '') . $c . ".\"");

            $readFromStream .= $c;

            if (array_key_exists($c, $mapping)) {

                if (is_string($mapping[$c])) {
                    $method = $mapping[$c];
                    $this->handler()->$method();
                    break;
                } elseif (is_array($mapping[$c])) {
                    $mapping = $mapping[$c];
                    continue;
                } else {
                    throw new \LogicException("Array key set, but found neither string nor array");
                }
            }

            $this->handler()->character($readFromStream);
            break;

        } while (true);
    }
}

interface KeyboardHandler
{
    public function character($char);

    public function leftArrow();
    public function rightArrow();
    public function upArrow();
    public function downArrow();
    public function home();
    public function end();
    public function pageUp();
    public function pageDown();
    public function backspace();
    public function tab();
    public function enter();
}

class EchoKeyboardHandler implements KeyboardHandler
{
    /**
     * @var
     */
    private $stream;

    public function __construct($stream)
    {
        $this->stream = $stream;
    }

    public function character($char)
    {
        $this->write($char);
    }

    public function leftArrow()
    {
        fwrite($this->stream, '←');
    }


    public function rightArrow()
    {
        fwrite($this->stream, '→');
    }

    public function upArrow()
    {
        fwrite($this->stream, '↑');
    }

    public function downArrow()
    {
        fwrite($this->stream, '↓');
    }


    public function home()
    {
        $this->write('⇐');
    }

    public function end()
    {
        $this->write('⇒');
    }

    public function pageUp()
    {
        $this->write('⇑');
    }

    public function pageDown()
    {
        $this->write('⇓');
    }

    public function backspace()
    {
        $this->write('⇦');
    }

    public function tab()
    {
        $this->write('➡');
    }

    public function enter()
    {
        $this->write('↳');
    }

    /**
     * @param $string
     */
    private function write($string)
    {
        fwrite($this->stream, $string);
        fflush($this->stream);
    }
}

class NullKeyboardHandler implements KeyboardHandler
{

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
    }

    public function downArrow()
    {
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
    }
}

class Terminal
{
    private $stream;

    public function __construct($stream)
    {
        $this->stream = $stream;
    }

    public function write($string)
    {
        fwrite($this->stream, $string);
    }

}

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

    public function __construct(Keyboard $keyboard, Terminal $terminal)
    {
        $this->keyboard = $keyboard;
        $this->terminal = $terminal;
    }

    public function ask($question, $choices)
    {
        $this->keyboard->setHandler($this);
        $this->terminal->write($question . "\n\n");

        $this->selectedChoiceIndex = 0;
        $this->choices = $choices;

        $this->outputChoices($this->choices, $this->selectedChoiceIndex);

        while (!$this->choiceMade) {
            $this->keyboard->next();
        }

        $this->keyboard->resetHandler();

        return $this->choices[$this->selectedChoiceIndex];

    }

    private function outputChoices($choices, $selectedIndex)
    {
        $choicesString = '';
        foreach ($choices as $index => $choice) {

            $selected = $index == $selectedIndex;
            $choicesString .= " ";

            $choicesString .= $selected
                ? chr(27)."[32m" . '➜'
                : '○';
            $choicesString .= " " . $choice;
            $choicesString .= $selected ? chr(27) ."[0m" : '';
            $choicesString .= "\n";
        }
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
        $this->outputChoices($this->choices, $this->selectedChoiceIndex);
    }

    public function downArrow()
    {
        $this->selectedChoiceIndex = $this->selectedChoiceIndex + 1;
        $this->selectedChoiceIndex = ($this->selectedChoiceIndex + count($this->choices)) % count($this->choices);

        $this->resetPositionForChoices();
        $this->outputChoices($this->choices, $this->selectedChoiceIndex);
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
        $this->keyboard->setHandler($this);

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



readline_callback_handler_install('', function() { });
//$keyboard = new Keyboard(STDIN, new EchoKeyboardHandler(STDOUT));
$keyboard = new Keyboard(STDIN, new NullKeyboardHandler(STDOUT));
//$keyboard = new Keyboard(STDIN);
$terminal = new Terminal(STDOUT);

$singleChoiceQuestionHelper = new SingleChoiceQuestionHelper($keyboard, $terminal);

$header = <<<HEADER
 __  __           _     _           _       
|  \/  | __ _ ___| |__ | |__   ___ | |_     
| |\/| |/ _` / __| '_ \| '_ \ / _ \| __|    
| |  | | (_| \__ \ | | | |_) | (_) | |_   _ 
|_|  |_|\__,_|___/_| |_|_.__/ \___/ \__| (_)


HEADER;

$terminal->write($header);
$seed = $singleChoiceQuestionHelper->ask('What type of project would you like to create?', ['Default', 'Symfony', 'Wordpress']);
$terminal->write("You chose $seed\n\n");


$singleLineTextValueHelper = new SingleLineTextValueHelper($keyboard, $terminal);
$singleLineTextValueHelper->ask('What\'s your project called?');

//while (true) {
//
//    $r = array(STDIN);
//    $w = NULL;
//    $e = NULL;
//    $n = stream_select($r, $w, $e, 0);
//
//    if ($n && in_array(STDIN, $r)) {
//        $keyboard->next();
//    }
//}
