<?php

require_once 'quizzer/Assessment.php';
require_once 'quizzer/deserializers/AssessmentDeserializer.php';

class AssessmentLoader
{
    public static function loadAssessmentFromUrls($questionsUrl, $answersUrl, $gradesUrl)
    {
        if (empty($questionsUrl) || empty($answersUrl)) {
            throw new Exception('Questions and answers URLs cannot be null');
        }

        $questionsJson = file_get_contents($questionsUrl);
        $answersJson = file_get_contents($answersUrl);

        $gradesJson = null;
        if (!empty($gradesUrl)) {
            $gradesJson = file_get_contents($gradesUrl);
        }

        return self::createAssessment($questionsJson, $answersJson, $gradesJson);
    }

    public static function loadAssessmentFromJsons($questionsJson, $answersJson, $gradesJson)
    {
        if (empty($questionsUrl) || empty($answersUrl)) {
            throw new Exception('Questions and answers URLs cannot be null');
        }

        return self::createAssessment($questionsJson, $answersJson, $gradesJson);
    }

    private static function createAssessment($questionsJson, $answersJson, $gradesJson)
    {
        $assessment = new Assessment();

        $assessment->setQuestions(AssessmentDeserializer::deserializeQuestions($questionsJson));
        $assessment->setAnswers(AssessmentDeserializer::deserializeAnswers($answersJson));

        if (!empty($gradesJson)) {
            $assessment->setGrades(AssessmentDeserializer::deserializeGrades($gradesJson));
        }
    }
} 