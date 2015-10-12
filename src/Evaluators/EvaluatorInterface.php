<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Psr\Http\Message\ServerRequestInterface;

interface EvaluatorInterface
{
    /**
     * @param \Mcustiel\PowerRoute\Matchers\MatcherInterface $matchers
     * @param \Psr\Http\Message\ServerRequestInterface       $request
     *
     * @return boolean
     */
    public function evaluate(MatcherInterface $matchers, ServerRequestInterface $request);
}