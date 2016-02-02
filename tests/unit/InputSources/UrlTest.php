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
        $this->evaluator->setArgument('full');
        $this->assertEquals(
            'http://www.example.com/?potato=banana#coconut',
            $this->evaluator->getValue($this->request)
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
        $this->evaluator->setArgument('host');
        $this->assertEquals('www.example.com', $this->evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheSchemePart()
    {
        $this->prepareUri('getScheme', 'http');
        $this->evaluator->setArgument('scheme');
        $this->assertEquals('http', $this->evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheAuthorityPart()
    {
        $this->prepareUri('getAuthority', 'potato@www.example.com:8080');
        $this->evaluator->setArgument('authority');
        $this->assertEquals('potato@www.example.com:8080', $this->evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheFragmentPart()
    {
        $this->prepareUri('getFragment', 'fragment');
        $this->evaluator->setArgument('fragment');
        $this->assertEquals('fragment', $this->evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetThePathPart()
    {
        $this->prepareUri('getPath', '/potato');
        $this->evaluator->setArgument('path');
        $this->assertEquals('/potato', $this->evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetThePortPart()
    {
        $this->prepareUri('getPort', '8080');
        $this->evaluator->setArgument('port');
        $this->assertEquals('8080', $this->evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheQueryPart()
    {
        $this->prepareUri('getQuery', 'potato=banana');
        $this->evaluator->setArgument('query');
        $this->assertEquals('potato=banana', $this->evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldGetTheUserInfoPart()
    {
        $this->prepareUri('getUserInfo', 'user:pass');
        $this->evaluator->setArgument('user-info');
        $this->assertEquals('user:pass', $this->evaluator->getValue($this->request));
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid config
     */
    public function shouldFailIfUrlPartIsNotSet()
    {
        $this->evaluator->setArgument('potato');
        $this->request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->uri);
        $this->evaluator->getValue($this->request);
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
