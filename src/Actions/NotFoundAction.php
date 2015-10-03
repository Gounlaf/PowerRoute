<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ResponseInterface;
use Mcustiel\PowerRoute\Http\Request;

class NotFoundAction extends AbstractArgumentAware implements ActionInterface
{
    public function execute(Request $request, ResponseInterface $response)
    {
        return $response->withStatus(404, 'Not Found');
    }
}
