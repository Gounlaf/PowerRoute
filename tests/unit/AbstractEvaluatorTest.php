<?php
namespace Mcustiel\PowerRoute\Tests;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Mcustiel\PowerRoute\Http\Request;

abstract class AbstractEvaluatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\PowerRoute\Matchers\MatcherInterface|\PHPUnit_Framework_MockObject_MockObject $matcher
     */
    protected $matcher;
    /**
     * @var \Mcustiel\PowerRoute\Http\Request|\PHPUnit_Framework_MockObject_MockObject $request
     */
    protected $request;

    public function setUp()
    {
        $this->matcher = $this->getMockBuilder(MatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
