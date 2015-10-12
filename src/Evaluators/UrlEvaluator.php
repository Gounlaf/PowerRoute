<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\RequestUrlAccess;

class UrlEvaluator extends AbstractArgumentAware implements EvaluatorInterface
{
    use RequestUrlAccess;

    public function evaluate(MatcherInterface $matcher, ServerRequestInterface $request)
    {
        return $matcher->match($this->getValueFromUrlPlaceholder($this->argument, $request->getUri()));
    }
}
