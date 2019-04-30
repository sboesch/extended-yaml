<?php
/**
 * Created by PhpStorm.
 * User: ions
 * Date: 2019-04-29
 * Time: 22:04
 */

namespace Sboesch\ExtendedYaml\Tests;

use Sboesch\ExtendedYaml\Exception\InvalidYamlException;
use Sboesch\ExtendedYaml\ExtendedYamlParser;
use PHPUnit\Framework\TestCase;

class ExtendedYamlParserTest extends TestCase
{

    public function testParseFile()
    {
        $subject = new ExtendedYamlParser();
        $payload = $subject->parseFile(__DIR__.'/Fixtures/extend.yaml');

        $this->assertInternalType('array', $payload);

        $this->assertArrayHasKey('roles', $payload['users']['user']);
        $this->assertArrayHasKey('roles', $payload['users']['admin']);

        $this->assertContains('ROLE_USER', $payload['users']['user']['roles']);
        $this->assertContains('ROLE_ADMIN', $payload['users']['admin']['roles']);

        $this->assertContains('ROLE_USER', $payload['extended_users']['user']['roles']);
        $this->assertContains('ROLE_ADMIN', $payload['extended_users']['admin']['roles']);

        $this->assertContains('ROLE_USER', $payload['nested_users']['level_1']['roles']);
        $this->assertContains('ROLE_USER', $payload['nested_users']['level_1']['level_2']['roles']);
        $this->assertContains('ROLE_USER', $payload['nested_users']['level_1']['level_2']['level_3']['roles']);
    }

    public function testParseFiles()
    {
        $subject = new ExtendedYamlParser();
        $payload = $subject->parseFiles([
            __DIR__.'/Fixtures/simple.yaml',
            __DIR__.'/Fixtures/extend.yaml'
        ]);

        $this->assertInternalType('array', $payload);
        $this->assertArrayHasKey('roles', $payload['users']['user']);
    }

    public function testParseFileNested()
    {
        $subject = new ExtendedYamlParser();
        $payload = $subject->parseFile(__DIR__.'/Fixtures/nested.yaml');

        $this->assertInternalType('array', $payload);

        $this->assertArrayHasKey('key', $payload['nested_10']);
        $this->assertEquals('test', $payload['nested_10']['key']);
    }

    public function testParseFileSelfReferencingLoop()
    {
        $subject = new ExtendedYamlParser();
        $this->expectException(InvalidYamlException::class);
        $subject->parseFile(__DIR__.'/Fixtures/self-referencing-loop.yaml');
    }

    public function testParseFileOverwrite()
    {
        $subject = new ExtendedYamlParser();
        $payload = $subject->parseFile(__DIR__.'/Fixtures/overwrite.yaml');

        $this->assertInternalType('array', $payload);
        $this->assertEquals('a', $payload['test_a']['value']);
        $this->assertEquals('b', $payload['test_b']['value']);
        $this->assertEquals('c', $payload['test_c']['value']);
        $this->assertEquals('c', $payload['test_d']['value']);
    }
}
