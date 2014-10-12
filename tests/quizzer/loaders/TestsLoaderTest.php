<?php

require_once 'quizzer/loaders/TestsLoader.php';

class TestsLoaderTest extends PHPUnit_Framework_TestCase
{
    private static $testsUrl = 'tests/resources/tests.json';

    public function testLoadAssessmentFromUrls()
    {
        $this->assertTrue(file_exists(self::$testsUrl), "Missing tests file");

        try {
            $tests = TestsLoader::loadTests(self::$testsUrl);
            $this->assertTrue(count($tests) == 1, 'Unexpected tests array size');
        } catch (Exception $e) {
            $this->fail('Exception not expected');
        }
    }
}
 