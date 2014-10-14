<?php

require_once 'quizzer/loaders/AssessmentLoader.php';
require_once 'quizzer/loaders/TestsLoader.php';
require_once 'quizzer/serializers/AssessmentSerializer.php';

if (php_sapi_name() != 'cli') {
    if (isset($_POST['questions']) && isset($_POST['answers'])) {
        $questions = $_POST['questions'];
        $answers = $_POST['answers'];
        $assessment = AssessmentLoader::loadAssessmentFromJsons($questions, $answers, null);
        $assessment->calculateGrades();
        echo AssessmentSerializer::serializeGrades($assessment->getGrades(), 'json');
    }
} else {
    try {
        parseArguments();
    } catch (Exception $e) {
        echo 'There was a problem while executing the program: ' . $e->getMessage();
    }
}

function calculateGrades($questionsUrl, $answersUrl)
{
    $assessment = null;

    try {
        $assessment = AssessmentLoader::loadAssessmentFromUrls($questionsUrl, $answersUrl, null);
        $assessment->calculateGrades();
    } catch (Exception $e) {
        // Return default value
    }

    return $assessment;
}

function parseArguments()
{
    $options = getopt("q:a:o:t:sh");

    if (isset($options['h'])) {
        showHelp();
    } else if (isset($options['t'])) {
        $valid = validateAssessments($options['t']);
        echo $valid? 'All tests OK\n' : 'Tests failed\n';
    } else if (isset($options['q']) && isset($options['a'])) {
        $assessment = calculateGrades($options['q'], $options['a']);

        $format = isset($options["o"])? $options["o"] : "json";

        showGrades($assessment->getGrades(), $format);

        if (isset($options['s'])) {
            showStatistics($assessment->getStatistics(), $format);
        }

    } else {
        showHelp();
    }
}

function showGrades($grades, $format) {
    echo "Assessment's grades:\n";
    echo AssessmentSerializer::serializeGrades($grades, $format) . "\n\n";
}

function showHelp()
{
    echo "usage: quizzer [options]\n";
    echo " -a <arg>   URL to the answers file\n";
    echo " -h         Show this help\n";
    echo " -o <arg>   Generate output in the specified format (json or xml)\n";
    echo " -q <arg>   URL to the questions file\n";
    echo " -s         Show questions statistics\n";
    echo " -t <arg>   Validate assessments in tests file\n";
}

function showStatistics($statistics, $format) {
    echo "Assessment's statistics:\n";
    echo AssessmentSerializer::serializeStatistics($statistics, $format) . "\n\n";
}

function validateAssessments($url)
{
    $valid = true;

    foreach (TestsLoader::loadTests($url) as $test) {
        try {
            $assessment = AssessmentLoader::loadAssessmentFromUrls($test->getQuestionsUrl(), $test->getAnswersUrl(),
                $test->getGradesUrl());
            if ($assessment->validateGrades()) {
                echo "Test valid\n";
            } else {
                $valid = false;
                echo "Test not valid\n";
            }
        } catch (Exception $e) {
            $valid = false;
        }
    }

    return $valid;
}