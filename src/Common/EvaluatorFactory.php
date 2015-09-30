<?php
namespace Mcustiel\PowerRoute\Common;

use Mcustiel\PowerRoute\Evaluators as Evaluator;

class EvaluatorFactory
{
    private $mapping = [
        'queryString' => Evaluator\QueryStringParamEvaluator::class,
        'cookie' => Evaluator\CookieEvaluator::class,
    ];

    public function __construct(array $mapping)
    {
        $this->mapping = array_merge($this->mapping, $mapping);
    }

    /**
     *
     * @param array $config
     *
     * @return \Mcustiel\PowerRoute\Evaluators\EvaluatorInterface
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
