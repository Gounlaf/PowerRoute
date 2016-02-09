<?php
namespace Mcustiel\PowerRoute\Common\Creation;

class SingletonLazyCreator extends LazyCreator implements CreatorInterface
{
    private $instance;

    public function getInstance()
    {
        if ($this->instance === null) {
            $this->instance = parent::getInstance();
        }
        return $this->instance;
    }
}
