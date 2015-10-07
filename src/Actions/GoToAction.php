<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class GoToAction extends AbstractAction implements ActionInterface
{
    public function execute(TransactionData $transactionData)
    {
        $this->argument->executor->execute(
            $this->getValueOrPlaceholder($this->argument->route, $transactionData->getRequest()),
            $transactionData
        );
    }
}
