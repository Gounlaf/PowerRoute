<?php
namespace Mcustiel\PowerRoute\Tests\Actions;

use Mcustiel\PowerRoute\Matchers\Equals;

class EqualsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\PowerRoute\Matchers\MatcherInterface
     */
    private $matcher;

    /**
     * @before
     */
    public function setMatcher()
    {
        $this->matcher = new Equals("potato");
    }

    /**
     * @test
     */
    public function shouldReturnTrue()
    {
        $this->assertTrue($this->matcher->match("potato"));
    }

    /**
     * @test
     */
    public function shouldReturnFalse()
    {
        $this->assertFalse($this->matcher->match("tomato"));
    }
}
