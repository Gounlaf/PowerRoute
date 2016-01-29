<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class Redirect implements ActionInterface
{
    use PlaceholderEvaluator, ArgumentAware;

    public function execute(TransactionData $transactionData)
    {
        return $transactionData->setResponse(
            $transactionData->getResponse()
            ->withHeader(
                'Location',
                $this->getValueOrPlaceholder($this->argument, $transactionData)
            )
            ->withStatus(302)
        );
    }
}
