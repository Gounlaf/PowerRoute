<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class NotNullMatcher extends AbstractArgumentAware implements MatcherInterface
{
    public function match($value)
    {
        return $value !== null;
    }
}