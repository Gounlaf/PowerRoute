<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class NotEmpty extends AbstractArgumentAware implements MatcherInterface
{
    public function match($value)
    {
        return !empty($value);
    }
}
