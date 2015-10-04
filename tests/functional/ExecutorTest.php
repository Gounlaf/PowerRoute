<?php
namespace Mcustiel\PowerRoute\Tests;

use Zend\Diactoros\Response;
use Mcustiel\PowerRoute\Http\Request;
use Mcustiel\PowerRoute\Common\RouteExecutor;
use Mcustiel\PowerRoute\Common\MatcherFactory;
use Mcustiel\PowerRoute\Common\EvaluatorFactory;
use Mcustiel\PowerRoute\Common\ActionFactory;
use Mcustiel\PowerRoute\Evaluators\CookieEvaluator;
use Mcustiel\PowerRoute\Matchers\NotNullMatcher;
use Mcustiel\PowerRoute\Actions\DisplayFileAction;
use Mcustiel\PowerRoute\Evaluators\QueryStringParamEvaluator;
use Mcustiel\PowerRoute\Matchers\InArrayMatcher;
use Mcustiel\PowerRoute\Actions\SaveCookieAction;
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
        $this->matcherFactory = new MatcherFactory([]);
        $this->evaluatorFactory = new EvaluatorFactory([]);
        $this->actionFactory = new ActionFactory([]);

        $this->executor = new RouteExecutor(
            include FIXTURES_PATH . '/functional-config.php',
            $this->actionFactory,
            $this->evaluatorFactory,
            $this->matcherFactory
        );
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
        $psrRequest = new \Zend\Diactoros\Request(
            'http://potato.org?a&b=potato',
            'get',
            'php://temp',
            ['Cookie' => 'cookieTest=baked;potato=coco']
        );
        $request = new Request($psrRequest);
        $response = new Response();

        $this->evaluatorFactory->addMapping('cookie', CookieEvaluator::class);
        $this->matcherFactory->addMapping('notNull', NotNullMatcher::class);
        $this->actionFactory->addMapping('displayFile', DisplayFileAction::class);

        $response = $this->executor->execute('route1', $request, $response);
        $this->assertEquals('potato baked', $response->getBody()->__toString());
    }

    /**
     * @test
     */
    public function shouldRunTheSecondRoute()
    {
        DateTimeUtils::setCurrentTimestampFixed((new \DateTime('2015-10-01 20:35:41'))->getTimestamp());

        $psrRequest = new \Zend\Diactoros\Request(
            'http://potato.org?a&b=test&potato=grilled',
            'get',
            'php://temp'
        );
        $request = new Request($psrRequest);
        $response = new Response();

        $this->evaluatorFactory->addMapping('cookie', CookieEvaluator::class);
        $this->evaluatorFactory->addMapping('queryString', QueryStringParamEvaluator::class);
        $this->matcherFactory->addMapping('notNull', NotNullMatcher::class);
        $this->matcherFactory->addMapping('inArray', InArrayMatcher::class);
        $this->actionFactory->addMapping('saveCookie', SaveCookieAction::class);
        $this->actionFactory->addMapping('displayFile', DisplayFileAction::class);

        $response = $this->executor->execute('route1', $request, $response);
        $this->assertEquals('potato grilled', $response->getBody()->__toString());
        $this->assertEquals(
            ['cookieTest=grilled; expires=Thursday, 01-Oct-2015 21:00:41 UTC; domain=; path=; secure'],
            $response->getHeader('Set-Cookie')
        );
    }
}
