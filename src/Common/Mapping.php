<?php
namespace Mcustiel\PowerRoute\Common;

class Mapping
{
    protected $mapping = [];

    public function __construct(array $mapping)
    {
        $this->mapping = array_merge($this->mapping, $mapping);
    }

    protected function checkMappingIsValid($mapping)
    {
        if (!isset($this->mapping[$mapping])) {
            throw new \Exception();
        }
    }

    public function addMapping($identifier, $class)
    {
        $this->mapping[$identifier] = $class;
    }
}
