<?php
namespace Mcustiel\PowerRoute\Common\Factories;

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

    public function addMapping($identifier, $classData)
    {
        $this->mapping[$identifier] = $classData;
    }

    protected function getClassName($classId)
    {
        return $this->mapping[$classId][0];
    }

    protected function getConstructorArguments($classId)
    {
        return array_slice($this->mapping[$classId], 1);
    }
}
