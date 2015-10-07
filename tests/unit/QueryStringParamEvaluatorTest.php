<?php
namespace Mcustiel\PowerRoute\Tests;

use Mcustiel\PowerRoute\Evaluators\QueryStringParamEvaluator;

class QueryStringParamEvaluatorTest extends AbstractEvaluatorTest
{
    /**
     * @test
     */
    public function shouldGetTheQueryStringParamAndPassItToMatcher()
    {
        $this->request
            ->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['banana' => 'potato']);
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('potato'));
        $evaluator = new QueryStringParamEvaluator('banana');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldPassNullToMatcherIfQueryStringParamIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['banana' => 'potato']);
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo(null));
        $evaluator = new QueryStringParamEvaluator('coconut');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldReturnSameValueAsMatcher()
    {
        $this->request
            ->expects($this->once())
            ->method('getQueryParams')
            ->willReturn([]);
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo(null))
            ->willReturn(true);
        $evaluator = new QueryStringParamEvaluator('coconut');
        $this->assertTrue($evaluator->evaluate($this->matcher, $this->request));
    }
}
