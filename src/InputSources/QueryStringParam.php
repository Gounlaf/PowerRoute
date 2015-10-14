<?php
namespace Mcustiel\PowerRoute\InputSources;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;

class QueryStringParam extends AbstractArgumentAware implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request)
    {
        $array = $request->getQueryParams();
        return isset($array[$this->argument])? $array[$this->argument] : null;
    }
}
