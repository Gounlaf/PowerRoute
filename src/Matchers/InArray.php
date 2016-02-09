<?php
namespace Mcustiel\PowerRoute\Matchers;

class InArray implements MatcherInterface
{
    public function match($value, $argument)
    {
        return in_array($value, $argument);
    }
}
