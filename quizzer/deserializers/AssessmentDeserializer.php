<?php

require_once 'quizzer/domain/Answer.php';
require_once 'quizzer/domain/Grade.php';
require_once 'quizzer/domain/questions/MultichoiceQuestion.php';
require_once 'quizzer/domain/questions/TrueFalseQuestion.php';

class AssessmentDeserializer
{
    /**
     * Deserializes the JSON representation received as arguments to a map of student ids to Answer objects.
     *
     * @param $json JSON representation of the answers objects
     * @return array an array of student ids to Answer objects
     */
    public static function deserializeAnswers($json)
    {
        $data = json_decode($json);
        $answers = array();

        if (isset($data->items)) {
            foreach ($data->items as $student) {
                if (isset($student->studentId) && isset($student->answers)) {
                    $studentAnswers = array();

                    foreach ($student->answers as $answer) {
                        if (isset($answer->question) && isset($answer->value)) {
                            $studentAnswers[] = new Answer($answer->question, $answer->value);
                        }
                    }

                    $answers[$student->studentId] = $studentAnswers;
                }
            }
        }

        return $answers;
    }

    /**
     * Deserializes the JSON representation received as arguments to a map of student ids to Grade objects.
     *
     * @param $json JSON representation of the grades objects
     * @return array an array of student ids to Grade objects
     */
    public static function deserializeGrades($json)
    {
        $data = json_decode($json);
        $grades = array();

        if (isset($data->scores)) {
            foreach ($data->scores as $grade) {
                if (isset($grade->studentId) && isset($grade->value)) {
                    $grades[$grade->studentId] = new Grade($grade->studentId, $grade->value);
                }
            }
        }

        return $grades;
    }

    /**
     * Deserializes the JSON representation received as arguments to a map of question ids to Question objects.
     *
     * @param $json JSON representation of the questions objects
     * @return array an array of question ids to Question objects
     */
    public static function deserializeQuestions($json)
    {
        $data = json_decode($json);
        $questions = array();

        if (isset($data->questions)) {
            foreach ($data->questions as $question) {
                if (isset($question->type) && isset($question->id) && isset($question->questionText)) {
                    $newQuestion = null;

                    if ($question->type == 'multichoice') {
                        $newQuestion = self::createMultichoiceQuestion($question);
                    } else if ($question->type == 'numerical') {
                        $newQuestion = self::createNumericalQuestion($question);
                    }
                    if ($question->type == 'truefalse') {
                        $newQuestion = self::createTruefalseQuestion($question);
                    }

                    if ($newQuestion != null) {
                        $questions[$question->id] = $newQuestion;
                    }
                }
            }
        }

        return $questions;
    }

    private static function createMultichoiceQuestion($question)
    {
        $multichoice = null;

        if (isset($question->alternatives)) {
            $multichoice = new MultichoiceQuestion($question->id, $question->questionText);
            foreach ($question->alternatives as $alternative) {
                if (isset($alternative->text) && isset($alternative->code) && isset($alternative->value)) {
                    $multichoice->addAlternative($alternative->code, $alternative->text, $alternative->value);
                }
            }
        }

        return $multichoice;
    }

    private static function createNumericalQuestion($question)
    {
        $numerical = null;

        if (isset($question->correct) && isset($question->valueOK) && isset($question->valueFailed)) {
            $numerical = new NumericalQuestion($question->id, $question->questionText);
            $numerical->setCorrect($question->correct);
            $numerical->setValueCorrect($question->valueOK);
            $numerical->setValueIncorrect($question->valueFailed);

        }

        return $numerical;
    }

    private static function createTrueFalseQuestion($question)
    {
        $truefalse = null;

        if (isset($question->correct) && isset($question->valueOK) && isset($question->valueFailed)
            && isset($question->feedback)
        ) {
            $truefalse = new TrueFalseQuestion($question->id, $question->questionText);
            $truefalse->setCorrect($question->correct);
            $truefalse->setValueCorrect($question->valueOK);
            $truefalse->setValueIncorrect($question->valueFailed);
            $truefalse->setFeedback($question->feedback);

        }

        return $truefalse;
    }
} 