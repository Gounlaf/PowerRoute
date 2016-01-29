<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\ArgumentAwareInterface;

interface InputSourceInterface extends ArgumentAwareInterface
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return mixed
     */
    public function getValue(ServerRequestInterface $request);
}
