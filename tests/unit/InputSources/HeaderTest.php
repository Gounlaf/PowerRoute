<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\InputSources\Header;

class HeaderTest extends AbstractInputSourceTest
{
    public function setUp()
    {
        parent::setUp();
        $this->evaluator = new Header();
    }

    /**
     * @test
     */
    public function shouldReturnTheValueOfTheHeader()
    {
        $this->request->expects($this->once())
            ->method('getHeaderLine')
            ->with('X-Banana')
            ->willReturn('potato');
        $this->evaluator->setArgument('X-Banana');
        $this->assertEquals('potato', $this->evaluator->getValue($this->request));
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
        $this->evaluator->setArgument('X-Banana');
        $this->assertNull($this->evaluator->getValue($this->request));
    }
}
