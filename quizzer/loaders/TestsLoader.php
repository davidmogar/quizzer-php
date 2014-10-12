<?php

require_once 'quizzer/deserializers/TestsDeserializer.php';

class TestsLoader
{
    public static function loadTests($testsUrl) {
        if (empty($testsUrl)) {
            throw new Exception('Tests URL cannot be null');
        }

        $testsJson = file_get_contents($testsUrl);

        return TestsDeserializer::deserialize($testsJson);
    }
} 