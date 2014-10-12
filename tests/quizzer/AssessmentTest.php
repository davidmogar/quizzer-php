<?php

require_once 'quizzer/Assessment.php';
require_once 'quizzer/domain/Answer.php';
require_once 'quizzer/domain/Grade.php';
require_once 'quizzer/domain/questions/MultichoiceQuestion.php';
require_once 'quizzer/domain/questions/NumericalQuestion.php';
require_once 'quizzer/domain/questions/TrueFalseQuestion.php';

class AssessmentTest extends PHPUnit_Framework_TestCase
{
    private $assessment;

    public function __construct()
    {
        $this->assessment = new Assessment();

        $questions = array();
        $answers = array();

        $multichoice = new MultichoiceQuestion(1, "Question 1");
        $multichoice->addAlternative(1, "Alternative 1", 0);
        $multichoice->addAlternative(2, "Alternative 2", 0.75);
        $questions[1] = $multichoice;

        $numerical = new NumericalQuestion(2, "Question 2");
        $numerical->setCorrect(4.3);
        $numerical->setValueCorrect(1);
        $numerical->setValueIncorrect(-0.5);
        $questions[2] = $numerical;

        $truefalse = new TrueFalseQuestion(3, "Question 3");
        $truefalse->setCorrect(true);
        $truefalse->setValueCorrect(1);
        $truefalse->setValueIncorrect(-0.25);
        $questions[3] = $truefalse;

        $answers[1] = array(
            new Answer(1, 2),
            new Answer(2, 4.3),
            new Answer(3, true)
        );

        $answers[2] = array(
            new Answer(1, 1),
            new Answer(2, 2),
            new Answer(3, false)
        );

        $this->assessment->setQuestions($questions);
        $this->assessment->setAnswers($answers);
    }

    public function testCalculateGrades()
    {
        $this->assessment->calculateGrades();

        $this->assertTrue(count($this->assessment->getGrades()) == 2, 'Unexpected grades size');
        $this->assertEquals($this->assessment->getGrades()[1]->getGrade(), 2.75,
                'Unexpected grade value for id 1', 0.05);
        $this->assertEquals($this->assessment->getGrades()[2]->getGrade(), -0.75,
            'Unexpected grade value for id 2', 0.05);
    }

    public function testCalculateStudentGrade() {
        $this->assertEquals($this->assessment->calculateStudentGrade(1), 2.75, 'Unexpected grade value for id 1', 0.05);
        $this->assertEquals($this->assessment->calculateStudentGrade(2), -0.75,
                'Unexpected grade value for id 2', 0.05);
    }

    public function testValidateGrade() {
        $this->assertTrue($this->assessment->validateGrade(new Grade(1, 2.75)),
                'Unexpected grade validation result for id 1');
        $this->assertFalse($this->assessment->validateGrade(new Grade(1, 0.75)),
                'Unexpected grade validation result for id 2');
    }

    public function testValidateGrades() {
        $grades = array(
            1 => new Grade(1, 2.75),
            2 => new Grade(2, -0.75)
        );

        $this->assessment->setGrades($grades);
        $this->assertTrue($this->assessment->validateGrades(), 'Unexpected validation result. Expected a valid grade');

        $grades = array(
            1 => new Grade(1, 2.75),
            2 => new Grade(2, 0.25)
        );

        $this->assessment->setGrades($grades);
        $this->assertFalse($this->assessment->validateGrades(), 'Unexpected validation result. Expected a not valid grade');
    }
} 