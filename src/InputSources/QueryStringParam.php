<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;

class QueryStringParam implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request, $argument)
    {
        $array = $request->getQueryParams();
        return isset($array[$argument])? $array[$argument] : null;
    }
}
