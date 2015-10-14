<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\InputSources\QueryStringParam;

class QueryStringParamTest extends AbstractInputSourceTest
{
    /**
     * @test
     */
    public function shouldReturnTheQueryStringParam()
    {
        $this->request
            ->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['banana' => 'potato']);
        $evaluator = new QueryStringParam('banana');
        $this->assertEquals('potato', $evaluator->getValue($this->request));
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
        $evaluator = new QueryStringParam('coconut');
        $this->assertNull($evaluator->getValue($this->request));
    }
}
