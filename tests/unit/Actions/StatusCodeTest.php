<?php
namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use Mcustiel\PowerRoute\Actions\ActionInterface;
use Mcustiel\PowerRoute\Actions\StatusCode;

class StatusCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\PowerRoute\Actions\ActionInterface
     */
    private $action;

    /**
     * @before
     */
    public function initAction()
    {
        $this->action = new StatusCode();
    }

    /**
     * @test
     */
    public function shouldSetAResponseWithDefaultStatusCode()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction);
        $this->assertEquals(200, $transaction->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSetAResponseWithGivenCode()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction, 505);
        $this->assertEquals(505, $transaction->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSetAResponseStatusCodeAndKeepOldDataFromResponse()
    {
        $transaction = new TransactionData(
            new ServerRequest(),
            new Response('data://text/plain,This is the previous text')
        );
        $this->action->execute($transaction, 204);
        $this->assertEquals(204, $transaction->getResponse()->getStatusCode());
        $this->assertEquals(
            'This is the previous text',
            $transaction->getResponse()->getBody()->__toString()
        );
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Invalid status code: 605
     */
    public function shouldFailDefaultOnInvalidStatusCode()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction, 605);
        $this->assertEquals(500, $transaction->getResponse()->getStatusCode());
    }
}
