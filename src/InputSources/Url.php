<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\RequestUrlAccess;

class Url implements InputSourceInterface
{
    use RequestUrlAccess;

    public function getValue(ServerRequestInterface $request, $argument = null)
    {
        return $this->getValueFromUrlPlaceholder($argument, $request->getUri());
    }
}
