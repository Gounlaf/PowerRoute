<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Psr\Http\Message\ServerRequestInterface;

interface EvaluatorInterface
{
    public function evaluate(MatcherInterface $matchers, ServerRequestInterface $request);
}