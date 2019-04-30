<?php

namespace Sboesch\ExtendedYaml\Tests;

use PHPUnit\Framework\TestCase;
use Sboesch\ExtendedYaml\ExtendedYaml;

class ExtendedYamlTest extends TestCase {

    public function testParseFile()
    {
        $payload = ExtendedYaml::parseFile(__DIR__.'/Fixtures/simple.yaml');

        $this->assertInternalType('array', $payload);
    }

    public function testParseFiles()
    {
        $payload = ExtendedYaml::parseFiles([
            __DIR__.'/Fixtures/simple.yaml',
            __DIR__.'/Fixtures/extend.yaml'
        ]);

        $this->assertInternalType('array', $payload);
    }

}
