<?php
namespace Mcustiel\PowerRoute\InputSources;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\RequestUrlAccess;

class Url extends AbstractArgumentAware implements InputSourceInterface
{
    use RequestUrlAccess;

    public function evaluate(MatcherInterface $matcher, ServerRequestInterface $request)
    {
        return $matcher->match($this->getValueFromUrlPlaceholder($this->argument, $request->getUri()));
    }
}
