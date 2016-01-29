<?php
namespace Mcustiel\PowerRoute\Common;

trait ArgumentAware
{
    /**
     * @var mixed
     */
    private $argument = null;

    /**
     * @param mixed $argument
     */
    public function setArgument($argument)
    {
        $this->argument = $argument;
    }
}
