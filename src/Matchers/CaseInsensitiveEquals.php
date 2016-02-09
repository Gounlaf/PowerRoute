<?php
namespace Mcustiel\PowerRoute\Matchers;

class CaseInsensitiveEquals implements MatcherInterface
{
    public function match($value, $argument)
    {
        return strtolower($value) == strtolower($argument);
    }
}
