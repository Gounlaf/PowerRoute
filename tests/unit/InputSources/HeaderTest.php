<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\InputSources\Header;

class HeaderTest extends AbstractInputSourceTest
{
    /**
     * @test
     */
    public function shouldReturnTheValueOfTheHeader()
    {
        $this->request->expects($this->once())
            ->method('getHeaderLine')
            ->with('X-Banana')
            ->willReturn('potato');
        $evaluator = new Header('X-Banana');
        $this->assertEquals('potato', $evaluator->getValue($this->request));
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
        $evaluator = new Header('X-Banana');
        $this->assertNull($evaluator->getValue($this->request));
    }
}
