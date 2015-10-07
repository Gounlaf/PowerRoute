<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;

class QueryStringParamEvaluator extends AbstractArgumentAware implements EvaluatorInterface
{
    public function evaluate(MatcherInterface $matcher, ServerRequestInterface $request)
    {
        $array = $request->getQueryParams();
        return $matcher->match(isset($array[$this->argument])? $array[$this->argument] : null);
    }
}
