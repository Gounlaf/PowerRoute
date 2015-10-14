<?php
namespace Mcustiel\PowerRoute\InputSources;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;

class Cookie extends AbstractArgumentAware implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request)
    {
        $array = $request->getCookieParams();
        return isset($array[$this->argument])? $array[$this->argument] : null;
    }
}
