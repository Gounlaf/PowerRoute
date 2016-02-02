<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\ArgumentAware;

class CaseInsensitiveEquals implements MatcherInterface
{
    use ArgumentAware;

    public function match($value)
    {
        return strtolower($value) == strtolower($this->argument);
    }
}
