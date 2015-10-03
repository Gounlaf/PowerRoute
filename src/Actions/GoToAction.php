<?php
namespace Mcustiel\PowerRoute\Actions;

use Psr\Http\Message\ResponseInterface;
use Mcustiel\PowerRoute\Http\Request;

class GoToAction extends AbstractAction implements ActionInterface
{
    public function execute(Request $request, ResponseInterface $response)
    {
        return $this->argument->executor->execute(
            $this->getValueOrPlaceholder($this->argument->route, $request),
            $request,
            $response
        );
    }
}
