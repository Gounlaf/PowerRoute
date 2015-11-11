<?php
namespace Mcustiel\PowerRoute\Tests;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Mcustiel\PowerRoute\Common\Executor;
use Mcustiel\PowerRoute\Common\MatcherFactory;
use Mcustiel\PowerRoute\Common\InputSourceFactory;
use Mcustiel\PowerRoute\Common\ActionFactory;
use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Actions\DisplayFile;
use Mcustiel\PowerRoute\Actions\SaveCookie;
use Mcustiel\PowerRoute\Actions\Redirect;
use Mcustiel\PowerRoute\InputSources\QueryStringParam;
use Mcustiel\PowerRoute\InputSources\Cookie;
use Mcustiel\PowerRoute\Matchers\NotNull;
use Mcustiel\PowerRoute\Matchers\InArray;
use Mcustiel\Mockable\DateTimeUtils;

class ExecutorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\PowerRoute\Common\RouteExecutor $executor
     */
    private $executor;

    /**
     * @var \Mcustiel\PowerRoute\Common\MatcherFactory $matcherFactory
     */
    private $matcherFactory;
    private $evaluatorFactory;
    private $actionFactory;

    /**
     * @before
     */
    public function buildExecutor()
    {
        $this->buildFactories();

        $this->executor = new Executor(
            include FIXTURES_PATH . '/functional-config.php',
            $this->actionFactory,
            $this->evaluatorFactory,
            $this->matcherFactory
        );

        $this->setMappings();
    }

    /**
     * @after
     */
    public function setTimeBackToNormal()
    {
        DateTimeUtils::setCurrentTimestampSystem();
    }

    /**
     * @test
     */
    public function shouldRunTheFirstRoute()
    {
        $request = new ServerRequest(
            [],
            [],
            'http://potato.org?a&b=potato',
            'get',
            'php://temp'
        );

        $transactionData = new TransactionData(
            $request->withCookieParams(
                ['cookieTest' => 'baked', 'potato' => 'coconut']
            ),
            new Response()
        );
        $this->executor->execute(
            'route1',
            $transactionData
        );
        $this->assertEquals('potato baked', $transactionData->getResponse()->getBody()->__toString());
    }

    /**
     * @test
     */
    public function shouldRunTheSecondRoute()
    {
        DateTimeUtils::setCurrentTimestampFixed((new \DateTime('2015-10-01 20:35:41'))->getTimestamp());

        $request = new ServerRequest(
            [],
            [],
            'http://potato.org?a&b=test&potato=grilled',
            'get',
            'php://temp'
        );

        $transactionData = new TransactionData(
            $request->withQueryParams(['a' => '', 'b' => 'test', 'potato' => 'grilled']),
            new Response()
        );
        $this->executor->execute(
            'route1',
            $transactionData
        );

        $this->assertEquals('potato grilled', $transactionData->getResponse()->getBody()->__toString());
        $this->assertEquals(
            [ 'cookieTest=grilled; expires=Thursday, 01-Oct-2015 21:35:41 UTC; domain=; path=; secure' ],
            $transactionData->getResponse()->getHeader('Set-Cookie')
        );
    }

    /**
     * @test
     */
    public function shouldRunTheDefaultRoute()
    {
        $request = new ServerRequest(
            [],
            [],
            'http://potato.org?a&b=test',
            'get',
            'php://temp'
        );
        $transactionData = new TransactionData($request, new Response());
        $this->executor->execute('route1', $transactionData);

        $this->assertEquals('', $transactionData->getResponse()->getBody()->__toString());
        $this->assertEquals([ 'http://www.google.com' ], $transactionData->getResponse()->getHeader('Location'));
        $this->assertEquals(302, $transactionData->getResponse()->getStatusCode());
    }

    private function buildFactories()
    {
        $this->matcherFactory = new MatcherFactory([]);
        $this->evaluatorFactory = new InputSourceFactory([]);
        $this->actionFactory = new ActionFactory([]);
    }

    private function setMappings()
    {
        $this->evaluatorFactory->addMapping('cookie', Cookie::class);
        $this->evaluatorFactory->addMapping('queryString', QueryStringParam::class);

        $this->matcherFactory->addMapping('notNull', NotNull::class);
        $this->matcherFactory->addMapping('inArray', InArray::class);

        $this->actionFactory->addMapping('saveCookie', SaveCookie::class);
        $this->actionFactory->addMapping('displayFile', DisplayFile::class);
        $this->actionFactory->addMapping('redirect', Redirect::class);
    }
}
