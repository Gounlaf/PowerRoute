<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

interface ActionInterface
{
    /**
     * @param \Mcustiel\PowerRoute\Common\TransactionData
     */
    public function execute(TransactionData $transactionData);
}
