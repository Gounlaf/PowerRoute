<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class Psr7MiddlewareAction implements ActionInterface
{
    /**
     * Executes a PSR-7 middleware.
     *
     * @param \Mcustiel\PowerRoute\Common\TransactionData                $transactionData
     * @param \Mcustiel\PowerRoute\Common\Conditions\ClassArgumentObject $argument
     */
    public function execute(TransactionData $transactionData, $argument = null)
    {
        $middleware = $argument->getInstance();

        $transactionData->setResponse(
            $middleware(
                $transactionData->getRequest(),
                $transactionData->getResponse(),
                $argument->getArgument()
            )
        );
    }
}
