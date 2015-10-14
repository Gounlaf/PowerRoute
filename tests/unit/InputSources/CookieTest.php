<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\InputSources\Cookie;

class CookieTest extends AbstractInputSourceTest
{
    /**
     * @test
     */
    public function shouldReturnTheValueOfTheCookie()
    {
        $this->request
            ->expects($this->once())
            ->method('getCookieParams')
            ->willReturn(['banana' => 'potato']);
        $evaluator = new Cookie('banana');
        $this->assertEquals('potato', $evaluator->getValue($this->request));
    }

    /**
     * @test
     */
    public function shouldReturnNullCookieIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getCookieParams')
            ->willReturn(['banana' => 'potato']);
        $evaluator = new Cookie('coconut');
        $this->assertNull($evaluator->getValue($this->request));
    }
}
