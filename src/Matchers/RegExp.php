<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\ArgumentAware;

class RegExp implements MatcherInterface
{
    use ArgumentAware;

    public function match($value)
    {
        return (boolean) preg_match($this->argument, $value);
    }
}
