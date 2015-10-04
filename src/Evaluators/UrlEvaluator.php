<?php
namespace Mcustiel\PowerRoute\Evaluators;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Mcustiel\PowerRoute\Http\Request;

class UrlEvaluator extends AbstractArgumentAware implements EvaluatorInterface
{
    public function evaluate($value, MatcherInterface $matcher, Request $request)
    {
        $value = $this->getValueFromUrl($request);
        return $matcher->match($request->url());
    }

    private function getValueFromUrl(Request $url)
    {
        switch($this->argument)
        {
            case 'full':
                return $url->url();
            case 'host':
                return $url->getPsr()->getUri()->getHost();
            case 'scheme':
                return $url->getPsr()->getUri()->getScheme();
            case 'authority':
                return $url->getPsr()->getUri()->getAuthority();
            case 'fragment':
                return $url->getPsr()->getUri()->getFragment();
            case 'path':
                return $url->getPsr()->getUri()->getPath();
            case 'port':
                return $url->getPsr()->getUri()->getPort();
            case 'query':
                return $url->getPsr()->getUri()->getQuery();
            case 'user-info':
                return $url->getPsr()->getUri()->getUserInfo();

            throw \Exception('Invalid config');
        }
    }
}
