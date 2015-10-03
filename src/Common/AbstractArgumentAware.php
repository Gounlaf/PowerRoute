<?php
namespace Mcustiel\PowerRoute\Common;

abstract class AbstractArgumentAware
{
    /**
     * @var mixed
     */
    protected $argument;

    public function __construct($argument = null)
    {
        $this->argument = $argument;
    }
}
