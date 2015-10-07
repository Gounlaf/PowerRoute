<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction extends AbstractArgumentAware
{
    const PLACEHOLDER_NOTATION = '/\{\{\s*(uri|get|post|header|cookie|method)(?:\.([a-z0-9-_]+))?\s*\}\}/i';

    protected function getValueOrPlaceholder($value, ServerRequestInterface $request)
    {
        return preg_replace_callback(self::PLACEHOLDER_NOTATION, function($matches) use ($request) {
            return $this->getValueFromPlaceholder(
                $matches[1],
                isset($matches[2]) ? $matches[2] : null,
                $request
            );
        }, $value);
    }

    private function getValueFromPlaceholder($from, $name, ServerRequestInterface $request)
    {
        switch($from) {
            case 'method':
                return $request->getMethod();
            case 'uri':
                return $request->getUri()->__toString();
            case 'get':
                return $request->getQueryParams()[$name];
            case 'header':
                return $request->getHeader($name);
            case 'cookie':
                return $request->getCookieParams()[$name];
            case 'post':
            case 'bodyParam':
                $data = $request->getParsedBody();
                return is_array($data) ? $data[$name] : $data->$name;
        }
    }
}
