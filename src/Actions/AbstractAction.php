<?php
namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\AbstractArgumentAware;
use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\RequestUrlAccess;

abstract class AbstractAction extends AbstractArgumentAware
{
    use RequestUrlAccess;
    const PLACEHOLDER_NOTATION = '/\{\{\s*(uri|get|post|header|cookie|method)(?:\.([a-z0-9-_]+))?\s*\}\}/i';

    /**
     *
     * @param mixed $value
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return mixed
     */
    protected function getValueOrPlaceholder($value, ServerRequestInterface $request)
    {
        return preg_replace_callback(
            self::PLACEHOLDER_NOTATION,
            function ($matches) use ($request) {
                return $this->getValueFromPlaceholder(
                    $matches[1],
                    isset($matches[2]) ? $matches[2] : null,
                    $request
                );
            },
            $value
        );
    }

    /**
     *
     * @param string $from
     * @param string|null $name
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return mixed
     */
    private function getValueFromPlaceholder($from, $name, ServerRequestInterface $request)
    {
        switch ($from) {
            case 'method':
                return $request->getMethod();
            case 'uri':
                return $this->getParsedUrl($name, $request);
            case 'get':
                return $request->getQueryParams()[$name];
            case 'header':
                return $request->getHeader($name);
            case 'cookie':
                return $request->getCookieParams()[$name];
            case 'post':
            case 'bodyParam':
                return $this->getValueFromParsedBody($name, $request);
        }
    }

    private function getParsedUrl($name, $request)
    {
        if ($name != null) {
            return $this->getValueFromUrlPlaceholder($name, $request->getUri());
        }
        return $request->getUri()->__toString();
    }

    private function getValueFromParsedBody($name, $request)
    {
        $data = $request->getParsedBody();
        return is_array($data) ? $data[$name] : $data->$name;
    }
}
