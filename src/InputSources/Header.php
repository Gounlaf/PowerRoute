<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class Header implements InputSourceInterface
{
    use ArgumentAware;

    public function getValue(ServerRequestInterface $request)
    {
        $header = $request->getHeaderLine($this->argument);
        return $header ?: null;
    }
}
