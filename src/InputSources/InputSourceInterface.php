<?php
namespace Mcustiel\PowerRoute\InputSources;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Psr\Http\Message\ServerRequestInterface;

interface InputSourceInterface
{
    /**
     * @param \Mcustiel\PowerRoute\Matchers\MatcherInterface $matchers
     * @param \Psr\Http\Message\ServerRequestInterface       $request
     *
     * @return boolean
     */
    public function getValue(ServerRequestInterface $request);
}
