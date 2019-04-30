<?php

namespace Sboesch\ExtendedYaml;

use Sboesch\ExtendedYaml\Exception\InvalidYamlException;
use Symfony\Component\Yaml\Yaml;

class ExtendedYamlParser {

    const MAX_EXTENSION_DEPTH = 1000;

    public function parseFiles (array $files) {

        $payload = '';

        foreach($files as $file) {
            $payload .= file_get_contents($file).PHP_EOL;
        }

        return $this->parse($payload);

    }

    public function parseFile (string $file) {

        $payload = file_get_contents($file);

        return $this->parse($payload);

    }

    public function parse (string $string) {

        $payload = Yaml::parse($string);
        $payload = $this->extendArray($payload);

        return $payload;

    }

    protected function extendArray(array $array, $context = null, $depth = 0) {

        if($depth > self::MAX_EXTENSION_DEPTH) {
            throw new InvalidYamlException('MAX_EXTENSION_DEPTH of '.self::MAX_EXTENSION_DEPTH.' reached.');
        }

        $result = $array;

        if(array_key_exists('$extends', $result) && $result['$extends']) {
            $extension = $this->getArrayValueByPath($array['$extends'], $context ?: $array);

            $array = array_merge($this->extendArray($extension, $context ?: $array, $depth+1), $result);

            unset($array['$extends']);
        }

        foreach($array as $key => $value) {
            if(is_array($value)) {
                $array[$key] = $this->extendArray($value, $context ?: $array, $depth+1);
            }
        }

        return $array;
    }

    protected function getArrayValueByPath(string $path, array $array) {
        $value = null;
        foreach(explode('.', $path) as $key) {
            $value = $value !== null ? $value[$key] : $array[$key];
        }
        return $value;
    }

}
