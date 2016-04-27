<?php
namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use Mcustiel\PowerRoute\Actions\ServerError;

class ServerErrorTest extends \PHPUnit_Framework_TestCase
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
        $this->action = new ServerError();
    }

    /**
     * @test
     */
    public function shouldSetAServerErrorResponseWithDefaultCode()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction);
        $this->assertEquals(500, $transaction->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSetAServerErrorResponseWithGivenCode()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction, 505);
        $this->assertEquals(505, $transaction->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSetAServerErrorResponseAndKeepOldDataFromResponse()
    {
        $transaction = new TransactionData(
            new ServerRequest(),
            new Response('data://text/plain,This is the previous text')
        );
        $this->action->execute($transaction);
        $this->assertEquals(500, $transaction->getResponse()->getStatusCode());
        $this->assertEquals(
            'This is the previous text',
            $transaction->getResponse()->getBody()->__toString()
        );
    }

    /**
     * @test
     */
    public function shouldSetDefaultOnInvalidStatusCode()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction, 499);
        $this->assertEquals(500, $transaction->getResponse()->getStatusCode());

        $this->action->execute($transaction, 600);
        $this->assertEquals(500, $transaction->getResponse()->getStatusCode());
    }
}
