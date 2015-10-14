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
    }

    /**
     * @test
     */
    public function shouldReturnTheFullUri()
    {
        $this->prepareUri('__toString', 'http://www.example.com/?potato=banana#coconut');
        $evaluator = new Url('full');
        $this->assertEquals(
            'http://www.example.com/?potato=banana#coconut',
            $evaluator->getValue($this->request)
        );
    }

    /**
     * @test
     */
    public function shouldGetTheHostPart()
    {
        $this->prepareUri('getHost', 'www.example.com');
        $evaluator = new Url('host');
        $this->assertEquals('www.example.com', $evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheSchemePart()
    {
        $this->prepareUri('getScheme', 'http');
        $evaluator = new Url('scheme');
        $this->assertEquals('http', $evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheAuthorityPart()
    {
        $this->prepareUri('getAuthority', 'potato@www.example.com:8080');
        $evaluator = new Url('authority');
        $this->assertEquals('potato@www.example.com:8080', $evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheFragmentPart()
    {
        $this->prepareUri('getFragment', 'fragment');
        $evaluator = new Url('fragment');
        $this->assertEquals('fragment', $evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetThePathPart()
    {
        $this->prepareUri('getPath', '/potato');
        $evaluator = new Url('path');
        $this->assertEquals('/potato', $evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetThePortPart()
    {
        $this->prepareUri('getPort', '8080');
        $evaluator = new Url('port');
        $this->assertEquals('8080', $evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheQueryPart()
    {
        $this->prepareUri('getQuery', 'potato=banana');
        $evaluator = new Url('query');
        $this->assertEquals('potato=banana', $evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheUserInfoPart()
    {
        $this->prepareUri('getUserInfo', 'user:pass');
        $evaluator = new Url('user-info');
        $this->assertEquals('user:pass', $evaluator->getValue($this->request));
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid config
     */
    public function shouldFailIfUrlPartIsNotSet()
    {
        $evaluator = new Url('potato');
        $this->request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->uri);
        $evaluator->getValue($this->request);
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
