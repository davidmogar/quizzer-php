<?php

require_once 'quizzer/domain/Test.php';

class TestsDeserializer
{
    public static function deserialize($json) {
        $data = json_decode($json);
        $tests = array();

        if (isset($data->tests)) {
            foreach($data->tests as $test) {
                if (isset($test->quizz) && isset($test->assessment) && isset($test->scores)) {
                    $tests[] = new Test($test->quizz, $test->assessment, $test->scores);
                }
            }
        }

        return $tests;
    }
} 