<?php
namespace Mcustiel\PowerRoute\Common;

abstract class AbstractArgumentAware
{
    /**
     * @var mixed
     */
    protected $argument;

    /**
     * @param mixed $argument
     */
    public function __construct($argument = null)
    {
        $this->argument = $argument;
    }
}
