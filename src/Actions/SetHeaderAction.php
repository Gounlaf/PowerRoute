<?php
namespace Mcustiel\PowerRoute\Actions;

use Psr\Http\Message\ResponseInterface;
use Mcustiel\PowerRoute\Http\Request;

class SetHeaderAction extends AbstractAction implements ActionInterface
{
    public function execute(Request $request, ResponseInterface $response)
    {
        $response->withHeader(
            $this->argument->name,
            $this->getValueOrPlaceholder($this->argument->value, $request)
        );
    }
}
