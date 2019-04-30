<?php

namespace Sboesch\ExtendedYaml;

class ExtendedYaml
{

    public static function parseFile(string $file) {

        $parser = new ExtendedYamlParser();
        $payload = $parser->parseFile($file);

        return $payload;

    }

    public static function parseFiles(array $files) {

        $parser = new ExtendedYamlParser();
        $payload = $parser->parseFiles($files);

        return $payload;

    }

}
