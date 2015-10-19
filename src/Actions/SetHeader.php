<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class SetHeader extends AbstractAction implements ActionInterface
{
    public function execute(TransactionData $transactionData)
    {
        return $transactionData->setResponse(
            $transactionData->getResponse()->withHeader(
                $this->argument->name,
                $this->getValueOrPlaceholder($this->argument->value, $transactionData)
            )
        );
    }
}
