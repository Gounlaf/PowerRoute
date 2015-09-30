<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Http\Request;
use Mcustiel\PowerRoute\Matchers\MatcherInterface;

interface EvaluatorInterface
{
    public function evaluate(MatcherInterface $matchers, Request $request);
}