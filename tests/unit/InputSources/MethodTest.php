<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\InputSources\Method;

class MethodTest extends AbstractInputSourceTest
{
    /**
     * @test
     */
    public function shouldReturnTheMethodInUpperCase()
    {
        $this->request
            ->expects($this->once())
            ->method('getMethod')
            ->willReturn('post');
        $evaluator = new Method();
        $this->assertEquals('POST', $evaluator->getValue($this->request));
    }
}
