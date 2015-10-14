<?php
namespace Mcustiel\PowerRoute\InputSources;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\RequestUrlAccess;

class Url extends AbstractArgumentAware implements InputSourceInterface
{
    use RequestUrlAccess;

    public function getValue(ServerRequestInterface $request)
    {
        return $this->getValueFromUrlPlaceholder($this->argument, $request->getUri());
    }
}
