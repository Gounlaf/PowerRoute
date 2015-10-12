<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\Mockable\DateTime;
use Mcustiel\PowerRoute\Common\TransactionData;

class SaveCookie extends AbstractAction implements ActionInterface
{
    public function execute(TransactionData $transactionData)
    {
        $transactionData->setResponse(
            $transactionData->getResponse()->withHeader(
                'Set-Cookie',
                $this->buildSetCookieHeaderValue(
                    $this->getValueOrPlaceholder($this->argument['value'], $transactionData->getRequest())
                )
            )
        );
    }

    private function buildSetCookieHeaderValue($value)
    {
        return $this->argument['name'] . '=' . $value . $this->getSetCookieDatePart()
            . (isset($this->argument['domain']) ? '; domain=' . $this->argument['domain'] : '')
            . (isset($this->argument['path']) ? '; path=' . $this->argument['path'] : '')
            . (isset($this->argument['secure']) ? '; secure' : '');
    }

    private function getSetCookieDatePart()
    {
        return isset($this->argument['ttl']) ? '; expires=' . date(
            DATE_COOKIE,
            ((new DateTime())->toPhpDateTime()->getTimestamp() + $this->argument['ttl'])
        ) : '';
    }
}
