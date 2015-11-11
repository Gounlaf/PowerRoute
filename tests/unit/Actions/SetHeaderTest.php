<?php
namespace Mcustiel\PowerRoute\Tests\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use Mcustiel\PowerRoute\Actions\ActionInterface;
use Mcustiel\PowerRoute\Actions\SetHeader;

class SetHeaderTest extends \PHPUnit_Framework_TestCase
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
        $this->action = new SetHeader(['name' => 'Location', 'value' => 'http://github.com']);
    }

    /**
     * @test
     */
    public function shouldSetAHeader()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction);
        $this->assertArrayHasKey('Location', $transaction->getResponse()->getHeaders());
        $this->assertEquals(
            'http://github.com',
            $transaction->getResponse()->getHeaderLine('Location')
        );
    }

    /**
     * @test
     */
    public function shouldSetAHeaderAndKeepOldDataFromResponse()
    {
        $transaction = new TransactionData(
            new ServerRequest(),
            new Response('data://text/plain,This is the previous text')
        );
        $this->action->execute($transaction);
        $this->assertArrayHasKey('Location', $transaction->getResponse()->getHeaders());
        $this->assertEquals(
            'http://github.com',
            $transaction->getResponse()->getHeaderLine('Location')
        );
        $this->assertEquals(
            'This is the previous text',
            $transaction->getResponse()->getBody()->__toString()
        );
    }
}