<?php
namespace Mcustiel\PowerRoute\Actions;

use Zend\Diactoros\Stream;
use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Common\ArgumentAware;

class DisplayFile implements ActionInterface
{
    use PlaceholderEvaluator, ArgumentAware;

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
