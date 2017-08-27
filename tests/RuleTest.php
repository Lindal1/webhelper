<?php
use lindal\webhelper\routing\Rule;
use lindal\webhelper\test\TestController;

class RuleTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider matchProvider
     * @param $pattern
     * @param $uri
     * @param $expected
     */
    public function testMatch($pattern, $uri, $expected)
    {
        $rule = new Rule(
            'Someclass',
            'execute',
            $pattern,
            'GET'
        );
        $this->assertEquals($rule->match($uri), $expected);
    }

    public function matchProvider()
    {
        return [
            ['/user/{id}', '/user', false],
            ['/user/{id}', '/user/32', true],
            ['/user/{id}', '/user/32/', false],
            ['/user/{id}', '/user/32/asdf', false],
            ['/user/{id}/test', '/user/32/test', true],
            ['/user/{id}/test', '/user/32/invalidtest', false],
            ['/user/{id}/test/{re}', '/user/32/test/31', true],
            ['/user/{id}/test/{re}', '/user/32/test/', false],
            ['/user', '/user', true],
            ['/user', '/user/32', false],
            ['/user', '/user?someParam', true],
        ];
    }

    /**
     * @dataProvider extractProvider
     * @param $pattern
     * @param $uri
     * @param $params
     */
    public function testExtractParams($pattern, $uri, $params)
    {
        $rule = new Rule(
            'Someclass',
            'handler',
            $pattern,
            'GET'
        );
        $this->assertEquals($rule->extractParams($uri), $params);
    }

    public function extractProvider()
    {
        return [
            ['/user/{id}', '/user/32', ['id' => 32]],
            ['/user/{product}', '/user/32', ['product' => 32]],
            ['/user/{id}/test/{test}', '/user/32/test/test', ['id' => 32, 'test' => 'test']],
            ['/user/{id}/test', '/user/32/test/test', ['id' => 32]],
        ];
    }

    public function testGetClass()
    {
        $rule = new Rule(
            TestController::class,
            'execute',
            '/user/{id}',
            'GET'
        );

        $this->assertEquals($rule->getClass(), TestController::class);
    }

    public function testGetHandler()
    {
        $rule = new Rule(
            TestController::class,
            'execute',
            '/user/{id}',
            'GET'
        );

        $this->assertEquals($rule->getHandler(), 'execute');
    }

    public function testGetMethod()
    {
        $rule = new Rule(
            TestController::class,
            'execute',
            '/user/{id}',
            'POST'
        );

        $this->assertEquals($rule->getMethod(), 'POST');
    }

    /**
     * @dataProvider providerForRemoveParams
     * @param $uri
     * @param $expectedUri
     */
    public function testRemoveGetParamsFromUri($uri, $expectedUri)
    {
        $rule = new Rule(
            TestController::class,
            'execute',
            '/user/{id}',
            'POST'
        );
        echo $rule->removeGetParamsFromUri($uri);
        $this->assertTrue($rule->removeGetParamsFromUri($uri) == $expectedUri);
    }

    public function providerForRemoveParams()
    {
        return [
            ['/user', '/user'],
            ['/user?som=1', '/user'],
            ['/user?som', '/user'],
            ['/user/add?som', '/user/add'],
            ['/user/add', '/user/add'],
        ];
    }
}