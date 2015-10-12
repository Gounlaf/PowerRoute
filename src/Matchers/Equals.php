<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class Equals extends AbstractArgumentAware implements MatcherInterface
{
    public function match($value)
    {
        return $value == $this->argument;
    }
}
