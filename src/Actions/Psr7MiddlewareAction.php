<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\Conditions\ClassArgumentObject;

class Psr7MiddlewareAction implements ActionInterface
{
    use PlaceholderEvaluator;

    /**
     * Executes a PSR-7 middleware.
     *
     * @param \Mcustiel\PowerRoute\Common\TransactionData                $transactionData
     * @param \Mcustiel\PowerRoute\Common\Conditions\ClassArgumentObject $argument
     */
    public function execute(TransactionData $transactionData, $argument = null)
    {
        $transactionData->setResponse(
            $argument->getInstance()->__invoke(
                $transactionData->getRequest(),
                $transactionData->getResponse(),
                $argument->getArgument()
            )
        );
    }
}
