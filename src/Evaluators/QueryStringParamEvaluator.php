<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;

class QueryStringParamEvaluator extends AbstractArgumentAware implements EvaluatorInterface
{
    public function evaluate(MatcherInterface $matcher, ServerRequestInterface $request)
    {
        $get = $request->getQueryParams();
        $value = isset($get[$this->argument])? $get[$this->argument] : null;
        return $matcher->match($value);
    }
}
