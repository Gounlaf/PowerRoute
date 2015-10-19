<?php
namespace Mcustiel\PowerRoute\Actions;

use Zend\Diactoros\Stream;
use Mcustiel\PowerRoute\Common\TransactionData;

class DisplayFile extends AbstractAction implements ActionInterface
{
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
