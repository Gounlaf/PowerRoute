<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class InArray extends AbstractArgumentAware implements MatcherInterface
{
    public function match($value)
    {
        return in_array($value, $this->argument);
    }
}
