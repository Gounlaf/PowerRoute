<?php
namespace Mcustiel\PowerRoute\Matchers;

class NotEmpty implements MatcherInterface
{
    public function match($value, $argument)
    {
        return !empty($value);
    }
}
