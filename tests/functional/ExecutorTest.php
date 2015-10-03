<?php
namespace Mcustiel\PowerRoute\Tests;

use Mcustiel\PowerRoute\Common\RouteExecutor;
use Mcustiel\PowerRoute\Common\MatcherFactory;
use Mcustiel\PowerRoute\Common\EvaluatorFactory;
use Mcustiel\PowerRoute\Common\ActionFactory;
use Zend\Diactoros\Response;
use Mcustiel\PowerRoute\Http\Request;
use Mcustiel\PowerRoute\Evaluators\CookieEvaluator;
use Mcustiel\PowerRoute\Matchers\NotNullMatcher;
use Mcustiel\PowerRoute\Actions\DisplayFileAction;

class ExecutorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mcustiel\PowerRoute\Common\RouteExecutor $executor
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
}
