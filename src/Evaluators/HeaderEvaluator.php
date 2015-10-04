<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Mcustiel\PowerRoute\Http\Request;

class HeaderEvaluator extends AbstractArgumentAware implements EvaluatorInterface
{
    public function evaluate($value, MatcherInterface $matcher, Request $request)
    {
        $header = $request->getPsr()->getHeader($this->argument);
        return $matcher->match(empty($header) ? null : $header[0]);
    }
}
