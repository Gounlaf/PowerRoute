<?php
namespace Mcustiel\PowerRoute\Tests\Actions;

use Mcustiel\PowerRoute\Matchers\RegExp;

class RegExpTest extends \PHPUnit_Framework_TestCase
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
        $this->matcher = new RegExp('/\d+/');
    }

    /**
     * @test
     */
    public function shouldReturnTrue()
    {
        $this->assertTrue($this->matcher->match('123456'));
    }

    /**
     * @test
     */
    public function shouldReturnFalse()
    {
        $this->assertTrue($this->matcher->match('123abc'));
    }
}
