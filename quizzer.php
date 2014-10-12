<?php

require_once 'quizzer/loaders/AssessmentLoader.php';
require_once 'quizzer/loaders/TestsLoader.php';

if (isset($_POST['questions']) && isset($_POST['answers'])) {
    $questions = $_POST['questions'];
    $answers = $_POST['answers'];
    $assessment = AssessmentLoader::loadAssessmentFromJsons($questions, $answers, null);
    $assessment->calculateGrades();
    var_dump($assessment->getGrades());
    echo ''; //Serialize grade
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
        echo $valid? 'All tests OK' : 'Tests failed';
    } else if (isset($options['q']) && isset($options['a'])) {
        $assessment = calculateGrades($options['q'], $options['a']);

        if (isset($options['s'])) {
            var_dump($assessment->getStatistics());
        }

    } else {
        showHelp();
    }
}

function showHelp()
{
    echo "usage: quizzer [options]\n";
    echo " -a <arg>   URL to the answers file\n";
    echo " -h         Show this help\n";
    echo " -o         Generate output\n";
    echo " -q <arg>   URL to the questions file\n";
    echo " -s         Show questions statistics\n";
    echo " -t <arg>   Validate assessments in tests file\n";
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