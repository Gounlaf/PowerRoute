<?php
namespace Mcustiel\PowerRoute\Actions;

use Zend\Diactoros\Stream;
use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class DisplayFile extends AbstractArgumentAware implements ActionInterface
{
    use PlaceholderEvaluator;

    public function execute(TransactionData $transactionData)
    {
        $transactionData->setResponse(
            $transactionData->getResponse()->withBody(
                new Stream('file://' . $this->getValueOrPlaceholder(
                    $this->argument,
                    $transactionData
                ))
            )
        );
    }
}
