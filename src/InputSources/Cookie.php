<?php
namespace Mcustiel\PowerRoute\InputSources;

use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class Cookie implements InputSourceInterface
{
    use ArgumentAware;

    public function getValue(ServerRequestInterface $request)
    {
        $array = $request->getCookieParams();
        return isset($array[$this->argument])? $array[$this->argument] : null;
    }
}
