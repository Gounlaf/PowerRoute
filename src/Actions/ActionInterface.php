<?php
namespace Mcustiel\PowerRoute\Actions;

use Psr\Http\Message\ResponseInterface;
use Mcustiel\PowerRoute\Http\Request;

interface ActionInterface
{
    /**
     * @param Request $dataBag
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function execute(Request $request, ResponseInterface $response);
}
