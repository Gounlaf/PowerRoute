<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class RedirectAction extends AbstractAction implements ActionInterface
{
    public function execute(TransactionData $transactionData)
    {
        return $transactionData->setResponse(
            $transactionData->getResponse()
            ->withHeader(
                'Location',
                $this->getValueOrPlaceholder($this->argument, $transactionData->getRequest())
            )
            ->withStatus(302)
        );
    }
}
