<?php
namespace Mcustiel\PowerRoute\Actions;

use Psr\Http\Message\ResponseInterface;
use Mcustiel\PowerRoute\Http\Request;
use Mcustiel\Mockable\DateTime;

class SaveCookieAction extends AbstractAction implements ActionInterface
{
    public function execute(Request $request, ResponseInterface $response)
    {
        $value = $this->getValueOrPlaceholder($this->argument['value'], $request);

        return $response->withHeader('Set-Cookie', $this->buildSetCookieHeaderValue($value));
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
