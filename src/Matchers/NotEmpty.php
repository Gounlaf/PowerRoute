<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\ArgumentAware;

class NotEmpty implements MatcherInterface
{
    use ArgumentAware;

    public function match($value)
    {
        return !empty($value);
    }
}
