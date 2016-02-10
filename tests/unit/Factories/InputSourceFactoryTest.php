<?php
namespace Mcustiel\PowerRoute\Tests\Factories;

use Mcustiel\PowerRoute\Common\Factories\InputSourceFactory;
use Mcustiel\PowerRoute\Common\AbstractArgumentAware;

class InputSourceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnAnInstanceIfItIsWasConfigured()
    {
        $this->markTestSkipped();
        $object = new \stdClass();
        $object->test = 'test';
        $factory = new InputSourceFactory(['potato' => $object]);
        $instance = $factory->createFromConfig(['potato' => null]);
        $this->assertSame($object, $instance);
    }

    public function shouldReturnAnInstanceAndSetArguments()
    {
        $this->markTestSkipped();
        $mock = $this->getMockBuilder(AbstractArgumentAware::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->once())
            ->method('setArgument')
            ->with($this->equalTo('tomato'));

        $factory = new InputSourceFactory(['potato' => $object]);
        $instance = $factory->createFromConfig(['potato' => 'tomato']);
        $this->assertSame($mock, $instance);
    }
}
