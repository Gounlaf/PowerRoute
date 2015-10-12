<?php
namespace Mcustiel\PowerRoute\Tests\s;

use Psr\Http\Message\UriInterface;
use Mcustiel\PowerRoute\InputSources\Url;

class UrlTest extends AbstractTest
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
    public function shouldGetTheFullUriAndPassItToMatcher()
    {
        $this->prepareUri('__toString', 'http://www.example.com/?potato=banana#coconut');
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('http://www.example.com/?potato=banana#coconut'));
        $evaluator = new Url('full');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldGetTheHostPart()
    {
        $this->prepareUri('getHost', 'www.example.com');
        $evaluator = new Url('host');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldGetTheSchemePart()
    {
        $this->prepareUri('getScheme', 'http');
        $evaluator = new Url('scheme');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldGetTheAuthorityPart()
    {
        $this->prepareUri('getAuthority', 'potato@www.example.com:8080');
        $evaluator = new Url('authority');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldGetTheFragmentPart()
    {
        $this->prepareUri('getFragment', 'fragment');
        $evaluator = new Url('fragment');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldGetThePathPart()
    {
        $this->prepareUri('getPath', '/potato');
        $evaluator = new Url('path');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldGetThePortPart()
    {
        $this->prepareUri('getPort', '8080');
        $evaluator = new Url('port');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldGetTheQueryPart()
    {
        $this->prepareUri('getQuery', 'potato=banana');
        $evaluator = new Url('query');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldGetTheUserInfoPart()
    {
        $this->prepareUri('getUserInfo', 'user:pass');
        $evaluator = new Url('user-info');
        $evaluator->evaluate($this->matcher, $this->request);
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
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldReturnSameValueAsMatcher()
    {
        $this->prepareUri('__toString', 'http://www.example.com/?potato=banana#coconut');
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('http://www.example.com/?potato=banana#coconut'))
            ->willReturn(true);
        $evaluator = new Url('full');
        $this->assertTrue($evaluator->evaluate($this->matcher, $this->request));
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
