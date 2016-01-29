<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\ArgumentAwareInterface;

interface ActionInterface extends ArgumentAwareInterface
{
    /**
     * @param \Mcustiel\PowerRoute\Common\TransactionData $transactionData This object is modified inside the class.
     */
    public function execute(TransactionData $transactionData);
}
