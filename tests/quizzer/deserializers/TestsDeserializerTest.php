<?php

require_once 'quizzer/deserializers/TestsDeserializer.php';

class TestsDeserializerTest extends PHPUnit_Framework_TestCase
{
    private static $testsUrl = 'tests/resources/tests.json';

    public function testDeserialize()
    {
        $this->assertTrue(file_exists(self::$testsUrl), "Missing tests file");

        $testsJson = file_get_contents(self::$testsUrl);
        $tests = TestsDeserializer::deserialize($testsJson);

        $this->assertTrue(count($tests) == 1, 'Unexpected size for tests array');
        $this->assertTrue($tests[0]->getQuestionsUrl() == 'tests/resources/questions.json');
        $this->assertTrue($tests[0]->getGradesUrl() == 'tests/resources/grades.json');
    }
}
 
