<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class Body implements InputSourceInterface
{
    use ArgumentAware;

    public function getValue(ServerRequestInterface $request)
    {
        return $request->getBody()->__toString();
    }
}
