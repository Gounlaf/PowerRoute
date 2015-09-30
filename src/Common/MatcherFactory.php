<?php
namespace Mcustiel\PowerRoute\Common;

use Mcustiel\PowerRoute\Matchers as Matchers;

class MatcherFactory
{
    private $mapping = [
        'equals' => Matchers\EqualsMatcher::class,
        'notNull' => Matchers\NotNullMatcher::class,
        'inArray' => Matchers\InArrayMatcher::class,
    ];

    public function __construct(array $mapping)
    {
        $this->mapping = array_merge($this->mapping, $mapping);
    }

    /**
     *
     * @param array $config
     *
     * @return \Mcustiel\PowerRoute\Matchers\MatcherInterface
     * @throws \Exception
     */
    public function createFromConfig(array $config)
    {
        if (!isset($this->mapping[$config['name']])) {
            throw new \Exception();
        }

        return new $this->mapping[$config['name']]($config['argument']);
    }
}
