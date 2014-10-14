<?php

require_once 'quizzer/deserializers/AssessmentDeserializer.php';

class AssessmentDeserializerTest extends PHPUnit_Framework_TestCase
{
    private static $questionsJson = '{ "questions": [ { "type": "multichoice", "id" : 1,
            "questionText": "Scala fue creado por...", "alternatives": [ { "text": "Martin Odersky", "code": 1,
            "value": 1 }, { "text": "James Gosling", "code": 2, "value": -0.25 }, { "text": "Guido van Rossum",
            "code": 3, "value": -0.25 } ] }, { "type" : "truefalse", "id" : 2,
            "questionText": "El creador de Ruby es Yukihiro Matsumoto", "correct": true, "valueOK": 1,
            "valueFailed": -0.25, "feedback": "Yukihiro Matsumoto es el principal desarrollador de Ruby desde 1996" } ] }';

    private static $answersJson = '{ "items": [ { "studentId": 234 , "answers": [ { "question" : 1, "value": 1 },
            { "question" : 2, "value": false } ] }, { "studentId": 245 , "answers": [ { "question" : 1, "value": 1 },
            { "question" : 2, "value": true } ] }, { "studentId": 221 , "answers": [ { "question" : 1,
            "value": 2 } ] } ] }';

    private static $gradesJson = '{ "scores": [ { "studentId": 234, "value": 0.75 } , { "studentId": 245,
            "value": 2.0 } , { "studentId": 221, "value": 0.75 } ] }';

    public function testDeserializeAnswers()
    {
        $answers = AssessmentDeserializer::deserializeAnswers(self::$answersJson);

        $this->assertNotNull($answers, 'Answers is null');
        $this->assertTrue(count($answers) == 3, 'Unexpected size for answers map');
        $this->assertTrue(count($answers[234]) == 2, 'Unexpected size for answers of student id 234');
        $this->assertTrue(count($answers[245]) == 2, 'Unexpected size for answers of student id 245');
        $this->assertTrue(count($answers[221]) == 1, 'Unexpected size for answers of student id 221');
    }

    public function testDeserializeGrades()
    {
        $grades = AssessmentDeserializer::deserializeGrades(self::$gradesJson);

        $this->assertNotNull($grades, 'Grades is null');
        $this->assertTrue(count($grades) == 3, 'Unexpected size for grades map');
        $this->assertEquals($grades[234]->getGrade(), 0.75, 'Grade value for id 234 doesn\'t match', 0.05);
        $this->assertEquals($grades[245]->getGrade(), 2, 'Grade value for id 234 doesn\'t match', 0.05);
        $this->assertEquals($grades[221]->getGrade(), 0.75, 'Grade value for id 221 doesn\'t match', 0.05);
    }

    public function testDeserializeQuestions()
    {
        $questions = AssessmentDeserializer::deserializeQuestions(self::$questionsJson);

        $this->assertNotNull($questions, 'Questions is null');
        $this->assertTrue(count($questions) == 2, 'Unexpected size for questions map');
        $this->assertTrue($questions[1] instanceof MultichoiceQuestion, 'Unexpected type for question 1');
        $this->assertTrue($questions[2] instanceof TrueFalseQuestion, 'Unexpected type for question 2');
        $this->assertTrue($questions[2]->getCorrect(), 'Unexpected value for question 2');

        $answers = AssessmentDeserializer::deserializeAnswers(self::$answersJson);
        $this->assertEquals($questions[1]->getScore($answers[234][0]), 1,
                'Unexpected score for answer 1 of student 234', 0.05);
    }
}
 
