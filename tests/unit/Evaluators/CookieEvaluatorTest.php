<?php
namespace Mcustiel\PowerRoute\Tests\s;

use Mcustiel\PowerRoute\InputSources\Cookie;

class CookieTest extends AbstractTest
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
        $evaluator = new Cookie('banana');
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
        $evaluator = new Cookie('coconut');
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
        $evaluator = new Cookie('coconut');
        $this->assertTrue($evaluator->evaluate($this->matcher, $this->request));
    }
}
