<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class NotEmptyMatcher extends AbstractArgumentAware implements MatcherInterface
{
    public function match($value)
    {
        return !empty($value);
    }
}