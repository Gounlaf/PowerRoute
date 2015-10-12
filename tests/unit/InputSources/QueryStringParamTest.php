<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\InputSources\QueryStringParam;

class QueryStringParamTest extends AbstractInputSourceTest
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
        $evaluator = new QueryStringParam('banana');
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
        $evaluator = new QueryStringParam('coconut');
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
        $evaluator = new QueryStringParam('coconut');
        $this->assertTrue($evaluator->evaluate($this->matcher, $this->request));
    }
}
