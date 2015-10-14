<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\Matchers\MatcherInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractInputSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Psr\Http\Message\ServerRequestInterface|\PHPUnit_Framework_MockObject_MockObject $request
     */
    protected $request;

    public function setUp()
    {
        $this->request = $this->getMockBuilder(ServerRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
