<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\ArgumentAware;

class InArray implements MatcherInterface
{
    use ArgumentAware;

    public function match($value)
    {
        return in_array($value, $this->argument);
    }
}
