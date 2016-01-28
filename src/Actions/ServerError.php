<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class ServerError extends AbstractArgumentAware implements ActionInterface
{
    public function execute(TransactionData $transactionData)
    {
        return $transactionData->setResponse(
            $transactionData->getResponse()->withStatus(
                $this->argument ? $this->argument : 500
            )
        );
    }
}
