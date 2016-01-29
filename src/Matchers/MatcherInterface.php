<?php
namespace Mcustiel\PowerRoute\Matchers;

use Mcustiel\PowerRoute\Common\ArgumentAwareInterface;

interface MatcherInterface extends ArgumentAwareInterface
{
    /**
     * @param mixed $value
     *
     * @return boolean
     */
    public function match($value);
}
