<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Mcustiel\PowerRoute\Http\Request;

class CookieEvaluator extends AbstractArgumentAware implements EvaluatorInterface
{
    public function evaluate(MatcherInterface $matcher, Request $request)
    {
        $cookies = $request->cookies();
        $value = isset($cookies[$this->argument])? $cookies[$this->argument] : null;
        return $matcher->match($value);
    }
}
