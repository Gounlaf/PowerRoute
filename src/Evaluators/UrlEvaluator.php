<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Mcustiel\PowerRoute\Http\Request;

class UrlEvaluator extends AbstractArgumentAware implements EvaluatorInterface
{
    public function evaluate($value, MatcherInterface $matcher, Request $request)
    {
        return $matcher->match($request->url());
    }
}
