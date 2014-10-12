<?php

require_once 'quizzer/loaders/AssessmentLoader.php';

if (isset($_POST['questions']) && isset($_POST['answers'])) {
    $questions = $_POST['questions'];
    $answers = $_POST['answers'];
    $assessment = AssessmentLoader::loadAssessmentFromJsons($questions, $answers, null);
    $assessment->calculateGrades();
    var_dump($assessment->getGrades());
    echo ''; //Serialize grade
} else {
    parseArguments();
}

function parseArguments()
{
    $options = getopt("q:a:o:t:h");

    if (isset($options['h'])) {
        //show help
    } else if (isset($options['t'])) {
        //run tests
        echo 'tests';
    } else if (isset($options['q']) && isset($options['a'])) {
        // calculate grades
        echo 'grades';
    } else {
        //show help
    }
}