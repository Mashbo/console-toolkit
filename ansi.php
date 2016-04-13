<?php


$CSR = function($code) {
    return chr(27) . "[" . $code;
};

echo "Hello" . $CSR('2D');
sleep(1); echo "L";
echo $CSR('?25l');
sleep(1); echo "O";

//echo chr(27) . "[42m" . "Hi" . chr() . chr(27) . "[0m";
sleep(2);
//echo chr(27) . "[5m" . "eegeg" . chr(27) . "[0m";

echo $CSR('0m');
echo $CSR('?25h');
