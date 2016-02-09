<?php
namespace Mcustiel\PowerRoute\Matchers;

class Equals implements MatcherInterface
{
    public function match($value, $argument)
    {
        return $value == $argument;
    }
}
