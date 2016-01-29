<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\RequestUrlAccess;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class Url implements InputSourceInterface
{
    use RequestUrlAccess, ArgumentAware;

    public function getValue(ServerRequestInterface $request)
    {
        return $this->getValueFromUrlPlaceholder($this->argument, $request->getUri());
    }
}
