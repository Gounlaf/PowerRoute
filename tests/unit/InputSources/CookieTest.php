<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\InputSources\Cookie;

class CookieTest extends AbstractInputSourceTest
{
    public function setUp()
    {
        parent::setUp();
        $this->evaluator = new Cookie();
    }

    /**
     * @test
     */
    public function shouldReturnTheValueOfTheCookie()
    {
        $this->request
            ->expects($this->once())
            ->method('getCookieParams')
            ->willReturn(['banana' => 'potato']);
        $this->evaluator->setArgument('banana');
        $this->assertEquals('potato', $this->evaluator->getValue($this->request));
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
        $this->evaluator->setArgument('coconut');
        $this->assertNull($this->evaluator->getValue($this->request));
    }
}
