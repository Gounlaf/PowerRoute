<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class Method implements InputSourceInterface
{
    use ArgumentAware;

    public function getValue(ServerRequestInterface $request)
    {
        return strtoupper($request->getMethod());
    }
}
