<?php
namespace Mcustiel\PowerRoute\Tests;

use Mcustiel\PowerRoute\Common\RouteExecutor;
use Mcustiel\PowerRoute\Common\MatcherFactory;
use Mcustiel\PowerRoute\Common\EvaluatorFactory;
use Mcustiel\PowerRoute\Common\ActionFactory;
use Zend\Diactoros\Response;
use Mcustiel\PowerRoute\Http\Request;

class ExecutorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mcustiel\PowerRoute\Common\RouteExecutor $executor
     */
    private $executor;

    /**
     * @before
     */
    public function buildExecutor()
    {
        $matcherFactory = new MatcherFactory([]);
        $evaluatorFactory = new EvaluatorFactory([]);
        $actionFactory = new ActionFactory([]);

        $this->executor = new RouteExecutor(
            include FIXTURES_PATH . '/functional-config.php',
            $actionFactory,
            $evaluatorFactory,
            $matcherFactory
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

        $this->executor->execute('route1', $request, $response);
        var_export($response->getBody()->__toString());
    }
}
