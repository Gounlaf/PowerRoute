<?php
namespace Mcustiel\PowerRoute\Common\Creation;

class ObjectDistributor implements CreatorInterface
{
    private $instance;

    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    public function getInstance()
    {
        return $this->instance;
    }
}
