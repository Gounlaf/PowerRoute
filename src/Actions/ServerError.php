<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class ServerError implements ActionInterface
{
    public function execute($argument, TransactionData $transactionData)
    {
        return $transactionData->setResponse(
            $transactionData->getResponse()->withStatus(
                $argument ? $argument : 500
            )
        );
    }
}
