<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class GoToAction implements ActionInterface
{
    use PlaceholderEvaluator, ArgumentAware;

    public function execute(TransactionData $transactionData)
    {
        $this->argument->executor->execute(
            $this->getValueOrPlaceholder($this->argument->route, $transactionData),
            $transactionData
        );
    }
}
