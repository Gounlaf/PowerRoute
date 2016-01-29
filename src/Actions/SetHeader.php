<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class SetHeader implements ActionInterface
{
    use PlaceholderEvaluator, ArgumentAware;

    public function execute(TransactionData $transactionData)
    {
        return $transactionData->setResponse(
            $transactionData->getResponse()->withHeader(
                $this->argument['name'],
                $this->getValueOrPlaceholder($this->argument['value'], $transactionData)
            )
        );
    }
}
