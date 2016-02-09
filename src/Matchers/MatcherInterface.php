<?php
namespace Mcustiel\PowerRoute\Matchers;

interface MatcherInterface
{
    /**
     * @param mixed $value
     * @param mixed $argument
     *
     * @return boolean
     */
    public function match($value, $argument);
}
