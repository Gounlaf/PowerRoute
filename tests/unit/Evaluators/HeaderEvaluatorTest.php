<?php
namespace Mcustiel\PowerRoute\Tests\s;

use Mcustiel\PowerRoute\InputSources\Header;

class HeaderTest extends AbstractTest
{
    /**
     * @test
     */
    public function shouldGetTheHeaderAndPassItToMatcher()
    {
        $this->request->expects($this->once())
            ->method('getHeaderLine')
            ->with('X-Banana')
            ->willReturn('potato');
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('potato'));
        $evaluator = new Header('X-Banana');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldPassNullToMatcherIfHeaderIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getHeaderLine')
            ->with('X-Banana')
            ->willReturn('');
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo(null));
        $evaluator = new Header('X-Banana');
        $evaluator->evaluate($this->matcher, $this->request);
    }

    /**
     * @test
     */
    public function shouldReturnSameValueAsMatcher()
    {
        $this->request->expects($this->once())
            ->method('getHeaderLine')
            ->with('X-Banana')
            ->willReturn('potato');
        $this->matcher
            ->expects($this->once())
            ->method('match')
            ->with($this->equalTo('potato'))
            ->willReturn(true);
        $evaluator = new Header('X-Banana');
        $this->assertTrue($evaluator->evaluate($this->matcher, $this->request));
    }
}
