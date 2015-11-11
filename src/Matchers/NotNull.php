<?php
namespace Mcustiel\PowerRoute\Matchers;

class NotNull implements MatcherInterface
{
    public function match($value)
    {
        return $value !== null;
    }
}
