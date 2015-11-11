<?php
namespace Mcustiel\PowerRoute\Tests\Actions;

use Mcustiel\PowerRoute\Matchers\InArray;

class InArrayTest extends \PHPUnit_Framework_TestCase
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
        $this->matcher = new InArray(['tomato' => 'potato']);
    }

    /**
     * @test
     */
    public function shouldReturnTrue()
    {
        $this->assertTrue($this->matcher->match('potato'));
    }

    /**
     * @test
     */
    public function shouldReturnFalse()
    {
        $this->assertFalse($this->matcher->match('tomato'));
    }
}
