<?php
namespace Mcustiel\PowerRoute\Actions;

use Psr\Http\Message\ResponseInterface;
use Mcustiel\PowerRoute\Http\Request;

class SaveCookieAction extends AbstractAction implements ActionInterface
{
    public function execute(Request $request, ResponseInterface $response)
    {
        $value = $this->getValueOrPlaceholder($this->argument->value, $request);

        $response->withHeader(
            'Set-Cookie',
            $this->argument->name . '=' . $value
            . (isset($this->argument->ttl)? '; expires=' . (time() + $this->argument->ttl) : '')
            . (isset($this->argument->domain)? '; domain=' . $this->argument->domain : '')
            . (isset($this->argument->path)? '; path=' . $this->argument->path : '')
            . (isset($this->argument->secure)? '; secure' : '')
        );
    }
}
