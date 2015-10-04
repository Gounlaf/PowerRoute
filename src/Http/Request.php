<?php
namespace Mcustiel\PowerRoute\Http;

use Psr\Http\Message\RequestInterface;

class Request
{
    private $psrRequest;

    private $url;
    private $queryStringParams;
    private $cookies;

    public function __construct(RequestInterface $request)
    {
        $this->psrRequest = $request;
    }

    public function get()
    {
        if ($this->queryStringParams === null) {
            $this->queryStringParams = $this->getParams($this->psrRequest->getUri()->getQuery(), '&');
        }
        return $this->queryStringParams;
    }

    public function cookies()
    {
        if ($this->cookies === null) {
            $cookies = $this->psrRequest->getHeader('Cookie');
            if (!empty($cookies)) {
                $this->cookies = $this->getParams($cookies[0], ';');
            }
        }
        return $this->cookies;
    }

    public function url()
    {
        if ($this->url === null) {
            $this->url = $this->psrRequest->getUri()->__toString();
        }

        return $this->url;
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getPsr()
    {
        return $this->psrRequest;
    }

    private function getParams($string, $separator)
    {
        $pairs = explode($separator, $string);
        $params = [];

        foreach ($pairs as $pair) {
            if (strpos($pair, '=') !== false) {
                list($name, $value) = explode('=', trim($pair));
                $params[$name] = urldecode($value);
            } else {
                $params[] = urldecode($pair);
            }
        }

        return $params;
    }
}
