<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class NotFound implements ActionInterface
{
    use ArgumentAware;

    public function execute(TransactionData $transactionData)
    {
        return $transactionData->setResponse($transactionData->getResponse()->withStatus(404, 'Not Found'));
    }
}
