<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Mcustiel\PowerRoute\Http\Request;

abstract class AbstractAction extends AbstractArgumentAware
{
    const PLACEHOLDER_NOTATION = '/\{\{\s*(uri|get|post|header|cookie|method)(?:\.([a-z0-9-_]+))?\s*\}\}/i';

    protected function getValueOrPlaceholder($value, Request $request)
    {
        return preg_replace_callback(self::PLACEHOLDER_NOTATION, function($matches) use ($request) {
            return $this->getValueFromPlaceholder(
                $matches[1],
                isset($matches[2]) ? $matches[2] : null,
                $request
            );
        }, $value);
    }

    private function getValueFromPlaceholder($from, $name, Request $request)
    {
        switch($from) {
            case 'method':
                return $request->getMethod();
            case 'uri':
                return $request->url();
            case 'get':
                return $request->get()[$name];
            case 'header':
                return $request->getPsr()->getHeader($name);
            case 'cookie':
                return $request->cookies()[$name];
            case 'post':
                return 'post';
        }
    }
}
