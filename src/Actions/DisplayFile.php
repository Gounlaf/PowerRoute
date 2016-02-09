<?php
namespace Mcustiel\PowerRoute\Actions;

use Zend\Diactoros\Stream;
use Mcustiel\PowerRoute\Common\TransactionData;

class DisplayFile implements ActionInterface
{
    use PlaceholderEvaluator;

    public function execute($argument, TransactionData $transactionData)
    {
        $transactionData->setResponse(
            $transactionData->getResponse()->withBody(
                new Stream('file://' . $this->getValueOrPlaceholder(
                    $argument,
                    $transactionData
                ))
            )
        );
    }
}
