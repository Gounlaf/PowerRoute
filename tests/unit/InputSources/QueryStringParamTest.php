<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\InputSources\QueryStringParam;

class QueryStringParamTest extends AbstractInputSourceTest
{
    public function setUp()
    {
        parent::setUp();
        $this->evaluator = new QueryStringParam();
    }

    /**
     * @test
     */
    public function shouldReturnTheQueryStringParam()
    {
        $this->request
            ->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['banana' => 'potato']);
        $this->evaluator->setArgument('banana');
        $this->assertEquals('potato', $this->evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldReturnNullIfQueryStringParamIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['banana' => 'potato']);
        $this->evaluator->setArgument('coconut');
        $this->assertNull($this->evaluator->getValue($this->request));
    }
}
