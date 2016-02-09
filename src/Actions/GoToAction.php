<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class GoToAction implements ActionInterface
{
    use PlaceholderEvaluator;

    public function execute($argument, TransactionData $transactionData)
    {
        $this->argument->executor->execute(
            $this->getValueOrPlaceholder($argument, $transactionData),
            $transactionData
        );
    }
}
