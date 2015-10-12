<?php
namespace Mcustiel\PowerRoute\InputSources;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;

class Header extends AbstractArgumentAware implements InputSourceInterface
{
    public function evaluate(MatcherInterface $matcher, ServerRequestInterface $request)
    {
        $header = $request->getHeaderLine($this->argument);
        return $matcher->match(empty($header) ? null : $header);
    }
}
