<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;

class UrlEvaluator extends AbstractArgumentAware implements EvaluatorInterface
{
    public function evaluate(MatcherInterface $matcher, ServerRequestInterface $request)
    {
        return $matcher->match($this->getValueFromUrl($request));
    }

    private function getValueFromUrl(ServerRequestInterface $request)
    {
        switch($this->argument)
        {
            case 'full':
                return $request->getUri()->__toString();
            case 'host':
                return $request->getUri()->getHost();
            case 'scheme':
                return $request->getUri()->getScheme();
            case 'authority':
                return $request->getUri()->getAuthority();
            case 'fragment':
                return $request->getUri()->getFragment();
            case 'path':
                return $request->getUri()->getPath();
            case 'port':
                return $request->getUri()->getPort();
            case 'query':
                return $request->getUri()->getQuery();
            case 'user-info':
                return $request->getUri()->getUserInfo();
            default:
            throw new \Exception('Invalid config');
        }
    }
}
