<?php
namespace Mcustiel\PowerRoute\Tests\Evaluators;

use Mcustiel\PowerRoute\Evaluators\QueryStringParamEvaluator;
use Psr\Http\Message\UriInterface;
use Mcustiel\PowerRoute\Evaluators\UrlEvaluator;

class UrlEvaluatorTest extends AbstractEvaluatorTest
{
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
    public function shouldGetTheUriPartRequestedAndPassItToMatcher()
    {
        $this->request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->uri);
        $this->uri
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('http://www.example.com/?potato=banana#coconut');
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('http://www.example.com/?potato=banana#coconut'));
        $evaluator = new UrlEvaluator('full');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid config
     */
    public function shouldFailIfUrlPartIsNotSet()
    {
        $evaluator = new UrlEvaluator('potato');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldReturnSameValueAsMatcher()
    {
        $this->request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->uri);
        $this->uri
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('http://www.example.com/?potato=banana#coconut');
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('http://www.example.com/?potato=banana#coconut'))
            ->willReturn(true);
        $evaluator = new UrlEvaluator('full');
        $this->assertTrue($evaluator->evaluate($this->matcher, $this->request));
    }
}
