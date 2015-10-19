<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class GoToAction extends AbstractArgumentAware implements ActionInterface
{
    use PlaceholderEvaluator;

    public function execute(TransactionData $transactionData)
    {
        $this->argument->executor->execute(
            $this->getValueOrPlaceholder($this->argument->route, $transactionData),
            $transactionData
        );
    }
}
