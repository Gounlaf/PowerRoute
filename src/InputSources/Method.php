<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;

class Method implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request)
    {
        return strtoupper($request->getMethod());
    }
}
