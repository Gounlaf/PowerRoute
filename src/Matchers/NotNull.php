<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\ArgumentAware;

class NotNull implements MatcherInterface
{
    use ArgumentAware;

    public function match($value)
    {
        return $value !== null;
    }
}
