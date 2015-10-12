<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

interface ActionInterface
{
    /**
     * @param \Mcustiel\PowerRoute\Common\TransactionData $transactionData
     */
    public function execute(TransactionData $transactionData);
}
