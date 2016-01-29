<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\ArgumentAware;

class Equals implements MatcherInterface
{
    use ArgumentAware;

    public function match($value)
    {
        return $value == $this->argument;
    }
}
