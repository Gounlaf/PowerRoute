<?php
namespace Mcustiel\PowerRoute\Tests\Evaluators;

use Mcustiel\PowerRoute\Evaluators\CookieEvaluator;

class CookieEvaluatorTest extends AbstractEvaluatorTest
{
    /**
     * @test
     */
    public function shouldGetTheCookieAndPassItToMatcher()
    {
        $this->request
            ->expects($this->once())
            ->method('getCookieParams')
            ->willReturn(['banana' => 'potato']);
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('potato'));
        $evaluator = new CookieEvaluator('banana');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldPassNullToMatcherIfCookieIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getCookieParams')
            ->willReturn(['banana' => 'potato']);
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo(null));
        $evaluator = new CookieEvaluator('coconut');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldReturnSameValueAsMatcher()
    {
        $this->request
            ->expects($this->once())
            ->method('getCookieParams')
            ->willReturn([]);
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo(null))
            ->willReturn(true);
        $evaluator = new CookieEvaluator('coconut');
        $this->assertTrue($evaluator->evaluate($this->matcher, $this->request));
    }
}
