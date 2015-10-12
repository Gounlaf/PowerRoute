<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class RegExp extends AbstractArgumentAware implements MatcherInterface
{
    public function match($value)
    {
        return preg_match($this->argument, $value);
    }
}