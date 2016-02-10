<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Psr\Http\Message\UriInterface;
use Mcustiel\PowerRoute\InputSources\Url;

class UrlTest extends AbstractInputSourceTest
{
    /**
     * @var \Psr\Http\Message\UriInterface|\PHPUnit_Framework_MockObject_MockObject $uri
     */
    private $uri;

    public function setUp()
    {
        parent::setUp();
        $this->uri = $this->getMockBuilder(UriInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->evaluator = new Url();
    }

    /**
     * @test
     */
    public function shouldReturnTheFullUri()
    {
        $this->prepareUri('__toString', 'http://www.example.com/?potato=banana#coconut');
        $this->assertEquals(
            'http://www.example.com/?potato=banana#coconut',
            $this->evaluator->getValue($this->request, 'full')
        );
    }

    /**
     * @test
     */
    public function shouldReturnTheFullUriWithNullArgument()
    {
        $this->prepareUri('__toString', 'http://www.example.com/?potato=banana#coconut');
        $this->assertEquals(
            'http://www.example.com/?potato=banana#coconut',
            $this->evaluator->getValue($this->request)
        );
    }

    /**
     * @test
     */
    public function shouldGetTheHostPart()
    {
        $this->prepareUri('getHost', 'www.example.com');
        $this->assertEquals('www.example.com', $this->evaluator->getValue($this->request, 'host'));
    }

    /**
     * @test
     */
    public function shouldGetTheSchemePart()
    {
        $this->prepareUri('getScheme', 'http');
        $this->assertEquals('http', $this->evaluator->getValue($this->request, 'scheme'));
    }

    /**
     * @test
     */
    public function shouldGetTheAuthorityPart()
    {
        $this->prepareUri('getAuthority', 'potato@www.example.com:8080');
        $this->assertEquals('potato@www.example.com:8080', $this->evaluator->getValue($this->request, 'authority'));
    }

    /**
     * @test
     */
    public function shouldGetTheFragmentPart()
    {
        $this->prepareUri('getFragment', 'fragment');
        $this->assertEquals('fragment', $this->evaluator->getValue($this->request, 'fragment'));
    }

    /**
     * @test
     */
    public function shouldGetThePathPart()
    {
        $this->prepareUri('getPath', '/potato');
        $this->assertEquals('/potato', $this->evaluator->getValue($this->request, 'path'));
    }

    /**
     * @test
     */
    public function shouldGetThePortPart()
    {
        $this->prepareUri('getPort', '8080');
        $this->assertEquals('8080', $this->evaluator->getValue($this->request, 'port'));
    }

    /**
     * @test
     */
    public function shouldGetTheQueryPart()
    {
        $this->prepareUri('getQuery', 'potato=banana');
        $this->assertEquals('potato=banana', $this->evaluator->getValue($this->request, 'query'));
    }

    /**
     * @test
     */
    public function shouldGetTheUserInfoPart()
    {
        $this->prepareUri('getUserInfo', 'user:pass');
        $this->assertEquals('user:pass', $this->evaluator->getValue($this->request, 'user-info'));
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid config
     */
    public function shouldFailIfUrlPartIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->uri);
        $this->evaluator->getValue($this->request, 'potato');
    }

    private function prepareUri($method, $returnValue)
    {
        $this->request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->uri);
        $this->uri
            ->expects($this->once())
            ->method($method)
            ->willReturn($returnValue);
    }
}
