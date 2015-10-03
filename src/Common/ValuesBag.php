<?php
namespace Mcustiel\PowerRoute\Common;

class ValuesBag
{
    private $values = [];

    public function get($name)
    {
        return isset($this->values[$name]) ? $this->values[$name] : null;
    }

    public function set($name, $value)
    {
        $this->values[$name] = $value;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }
}