<?php
namespace Mcustiel\PowerRoute\Actions;

use Psr\Http\Message\ResponseInterface;
use Mcustiel\PowerRoute\Http\Request;
use Zend\Diactoros\Stream;

class DisplayFileAction extends AbstractAction implements ActionInterface
{
    public function execute(Request $request, ResponseInterface $response)
    {
        $response->withBody(
            new Stream('file://' . $this->getValueOrPlaceholder($this->argument, $request))
        );
        var_export($response->getBody()->__toString());
    }
}
