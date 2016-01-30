<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\InputSources\Method;

class MethodTest extends AbstractInputSourceTest
{
    public function setUp()
    {
        parent::setUp();
        $this->evaluator = new Method();
    }

    /**
     * @test
     */
    public function shouldReturnTheMethodInUpperCase()
    {
        $this->request
            ->expects($this->once())
            ->method('getMethod')
            ->willReturn('post');
        $this->assertEquals('POST', $this->evaluator->getValue($this->request));
    }
}