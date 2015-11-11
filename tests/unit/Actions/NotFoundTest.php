<?php
namespace Mcustiel\PowerRoute\Tests\InputSources;

use Mcustiel\PowerRoute\Actions\NotFound;
use Mcustiel\PowerRoute\Common\TransactionData;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use Mcustiel\PowerRoute\Actions\ActionInterface;

class NotFoundTest extends \PHPUnit_Framework_TestCase
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
        $this->action = new NotFound();
    }

    /**
     * @test
     */
    public function shouldSetANotFoundResponse()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction);
        $this->assertEquals(404, $transaction->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSetANotFoundResponseAndKeepOldDataFromResponse()
    {
        $transaction = new TransactionData(
            new ServerRequest(),
            new Response('data://text/plain,This is the previous text')
        );
        $this->action->execute($transaction);
        $this->assertEquals(404, $transaction->getResponse()->getStatusCode());
        $this->assertEquals(
            'This is the previous text',
            $transaction->getResponse()->getBody()->__toString()
        );
    }
}
