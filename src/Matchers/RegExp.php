<?php
namespace Mcustiel\PowerRoute\Matchers;

class RegExp implements MatcherInterface
{
    public function match($value, $argument = null)
    {
        return (boolean) preg_match($argument, $value);
    }
}
