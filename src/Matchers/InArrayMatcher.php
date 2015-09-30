<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class InArrayMatcher extends AbstractArgumentAware implements MatcherInterface
{
    public function match($value)
    {
        return in_array($value, $this->argument);
    }
}