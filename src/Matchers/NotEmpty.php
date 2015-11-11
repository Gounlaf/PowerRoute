<?php
namespace Mcustiel\PowerRoute\Matchers;

class NotEmpty implements MatcherInterface
{
    public function match($value)
    {
        return !empty($value);
    }
}
