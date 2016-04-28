<?php

namespace Mashbo\ConsoleToolkit\Arguments;

class UnixStyleArgumentDataMapper implements ArgumentDataMapper
{
    /**
     * @var
     */
    private $mapping;

    public function __construct($mapping)
    {
        $this->mapping = $mapping;
    }

    /**
     * @return array
     */
    public function resolve(ArgumentList $list)
    {
        $resolvedArgs = [];
        foreach ($list as $index => $token) {
            $this->parseToken($index, $token, $resolvedArgs);
        }

        return $resolvedArgs;
    }

    private function parseToken($index, $token, &$resolvedArgs)
    {
        if (strlen($token) > 4 && substr($token, 0, 2) == '--') {
            $keyValue = substr($token, 2);
            preg_match('/^([a-z\-\.]+)=(.*)$/', $keyValue, $parts);

            $resolvedArgs[$this->mapping[$parts[1]]] = $parts[2];
            return;
        }

        $resolvedArgs[$this->mapping[$index]] = $token;
    }
}
