<?php
namespace Mcustiel\PowerRoute\InputSources;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;

class Header extends AbstractArgumentAware implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request)
    {
        $header = $request->getHeaderLine($this->argument);
        return $header ?: null;
    }
}
