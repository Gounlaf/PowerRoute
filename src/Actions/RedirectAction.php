<?php
namespace Mcustiel\PowerRoute\Actions;

use Psr\Http\Message\ResponseInterface;
use Mcustiel\PowerRoute\Http\Request;

class RedirectAction extends AbstractAction implements ActionInterface
{
    public function execute(Request $request, ResponseInterface $response)
    {
        $response->withHeader('Location', $this->getValueOrPlaceholder($this->argument, $request));
    }
}
