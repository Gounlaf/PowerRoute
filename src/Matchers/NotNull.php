<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class NotNull extends AbstractArgumentAware implements MatcherInterface
{
    public function match($value)
    {
        return $value !== null;
    }
}
