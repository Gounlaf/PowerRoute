<?php
namespace Mcustiel\PowerRoute\InputSources;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;

class QueryStringParam extends AbstractArgumentAware implements InputSourceInterface
{
    public function evaluate(MatcherInterface $matcher, ServerRequestInterface $request)
    {
        $array = $request->getQueryParams();
        return $matcher->match(isset($array[$this->argument])? $array[$this->argument] : null);
    }
}
