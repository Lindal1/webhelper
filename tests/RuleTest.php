<?php

/**
 * Created by PhpStorm.
 * User: lindal
 * Date: 21.08.17
 * Time: 22:07
 */
class RuleTest extends \PHPUnit\Framework\TestCase
{

    public $rule;

    public function setUp()
    {
        $this->rule = new \lindal\webhelper\routing\Rule(
            'Someclass',
            'handler',
            '/user/{id}',
            'GET'
        );
    }

    public function testMatch()
    {
        $validUri = '/user/43';
        $invalidUri = '/user/43/dsa';
        $this->assertTrue($this->rule->match($validUri));
        $this->assertFalse($this->rule->match($invalidUri));
    }

    public function testExtractParams()
    {
        $uri = '/user/43';
        $params = $this->rule->extractParams($uri);
        $this->assertEquals(['id' => 43], $params);
    }
}