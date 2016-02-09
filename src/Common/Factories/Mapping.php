<?php
namespace Mcustiel\PowerRoute\Common\Factories;

use Mcustiel\PowerRoute\Common\Creation\CreatorInterface;

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
            throw new \Exception("Did not find a mapped class identified by $mapping");
        }
    }

    public function addMapping($identifier, CreatorInterface $creator)
    {
        $this->mapping[$identifier] = $creator;
    }
}
