<?php
namespace Mcustiel\PowerRoute\Matchers;

interface MatcherInterface
{
    /**
     * @param mixed $value
     *
     * @return boolean
     */
    public function match($value);
}
