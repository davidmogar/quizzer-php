<?php

require_once 'quizzer/Assessment.php';
require_once 'quizzer/deserializers/AssessmentDeserializer.php';

class AssessmentLoader
{
    /**
     * Returns a new Assessment created with the data obtained from the URLs received as arguments.
     *
     * @param $questionsUrl URL to the questions file
     * @param $answersUrl URL to the answers file
     * @param $gradesUrl URL to the grades file
     * @return Assessment an Assessment with the data from the URLs received as arguments
     * @throws Exception if there is an error while fetching content from the given URLs
     */
    public static function loadAssessmentFromUrls($questionsUrl, $answersUrl, $gradesUrl)
    {
        if (!isset($questionsUrl) || !isset($answersUrl)) {
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

    /**
     * Returns a new Assessment created with the data obtained from the JSONs received as arguments.
     *
     * @param $questionsJson JSON representation of the questions file
     * @param $answersJson JSON representation of the answers file
     * @param $gradesJson JSON representation of the grades file
     * @return Assessment an Assessment with the data from the JSONs received as arguments
     * @throws Exception if questions or answers json arguments are null
     */
    public static function loadAssessmentFromJsons($questionsJson, $answersJson, $gradesJson)
    {
        if (!isset($questionsJson) || !isset($answersJson)) {
            throw new Exception('Questions and answers URLs cannot be null');
        }

        return self::createAssessment($questionsJson, $answersJson, $gradesJson);
    }

    /**
     * Creates and returns an Assessment with the data obtained after deserialize the given JSONs.
     *
     * @param $questionsJson JSON representation of the questions file
     * @param $answersJson JSON representation of the answers file
     * @param $gradesJson JSON representation of the grades file
     * @return Assessment an Assessment with the data from the JSONs received as arguments
     */
    private static function createAssessment($questionsJson, $answersJson, $gradesJson)
    {
        $assessment = new Assessment();

        $assessment->setQuestions(AssessmentDeserializer::deserializeQuestions($questionsJson));
        $assessment->setAnswers(AssessmentDeserializer::deserializeAnswers($answersJson));

        if (!empty($gradesJson)) {
            $assessment->setGrades(AssessmentDeserializer::deserializeGrades($gradesJson));
        }

        return $assessment;
    }
} 