<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Mcustiel\PowerRoute\Http\Request;

class QueryStringParamEvaluator extends AbstractArgumentAware implements EvaluatorInterface
{
    public function evaluate(MatcherInterface $matcher, Request $request)
    {
        $get = $request->get();
        $value = isset($get[$this->argument])? $get[$this->argument] : null;
        return $matcher->match($value);
    }
}
