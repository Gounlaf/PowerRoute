<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class Header implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request, $argument)
    {
        $header = $request->getHeaderLine($argument);
        return $header ?: null;
    }
}
