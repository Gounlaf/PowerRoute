<?php
namespace Mcustiel\PowerRoute\Tests;

use Mcustiel\PowerRoute\Evaluators\HeaderEvaluator;
use Psr\Http\Message\ResponseInterface;

class HeaderEvaluatorTest extends AbstractEvaluatorTest
{
    private $psrRequest;

    public function setUp()
    {
        parent::setUp();
        $this->psrRequest = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalClone()
            ->getMock();
        $this->request
            ->expects($this->once())
            ->method('getPsr')
            ->willReturn($this->psrRequest);
    }

    /**
     * @test
     */
    public function shouldGetTheHeaderAndPassItToMatcher()
    {
        $this->psrRequest->expects($this->once())
            ->method('getHeader')
            ->with('X-Banana')
            ->willReturn(['potato']);
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('potato'));
        $evaluator = new HeaderEvaluator('X-Banana');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldPassNullToMatcherIfHeaderIsNotSet()
    {
        $this->psrRequest
            ->expects($this->once())
            ->method('getHeader')
            ->with('X-Banana')
            ->willReturn([]);
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo(null));
        $evaluator = new HeaderEvaluator('X-Banana');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldReturnSameValueAsMatcher()
    {
        $this->psrRequest->expects($this->once())
            ->method('getHeader')
            ->with('X-Banana')
            ->willReturn(['potato']);
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('potato'))
            ->willReturn(true);
        $evaluator = new HeaderEvaluator('X-Banana');
        $this->assertTrue($evaluator->evaluate($this->matcher, $this->request));
    }
}
