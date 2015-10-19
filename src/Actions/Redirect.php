<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class Redirect extends AbstractArgumentAware implements ActionInterface
{
    use PlaceholderEvaluator;

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
