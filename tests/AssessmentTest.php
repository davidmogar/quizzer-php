<?php

require 'quizzer/Assessment.php';
require 'quizzer/domain/Answer.php';
require 'quizzer/domain/Grade.php';
require 'quizzer/domain/questions/MultichoiceQuestion.php';
require 'quizzer/domain/questions/TrueFalseQuestion.php';

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

        $truefalse = new TrueFalseQuestion(2, "Question 2");
        $truefalse->setCorrect(true);
        $truefalse->setValueCorrect(1);
        $truefalse->setValueIncorrect(-0.25);
        $questions[2] = $truefalse;

        $answers[1] = array(
            new Answer(1, "2"),
            new Answer(2, "true")
        );

        $answers[2] = array(
            new Answer(1, "0"),
            new Answer(2, "false")
        );

        $this->assessment->setQuestions($questions);
        $this->assessment->setAnswers($answers);
    }

    public function testCalculateGrades()
    {
        $this->assessment->calculateGrades();

        $this->assertTrue(count($this->assessment->getGrades()) == 2, 'Unexpected grades size');
        $this->assertEquals($this->assessment->getGrades()[1]->getGrade(), 1.75, 'Unexpected grade value for id 1', 0.05);
        $this->assertEquals($this->assessment->getGrades()[2]->getGrade(), -0.25, 'Unexpected grade value for id 2', 0.05);
    }

    public function testCalculateStudentGrade() {
        $this->assertEquals($this->assessment->calculateStudentGrade(1), 1.75, 'Unexpected grade value for id 1', 0.05);
        $this->assertEquals($this->assessment->calculateStudentGrade(2), -0.25, 'Unexpected grade value for id 2', 0.05);
    }

    public function testValidateGrade() {
        $this->assertTrue($this->assessment->validateGrade(new Grade(1, 1.75)), 'Unexpected grade validation result for id 1');
        $this->assertFalse($this->assessment->validateGrade(new Grade(1, 0.75)), 'Unexpected grade validation result for id 2');
    }

    public function testValidateGrades() {
        $grades = array(
            1 => new Grade(1, 1.75),
            2 => new Grade(2, -0.25)
        );

        $this->assessment->setGrades($grades);
        $this->assertTrue($this->assessment->validateGrades(), 'Unexpected validation result. Expected a valid grade');

        $grades = array(
            1 => new Grade(1, 1.75),
            2 => new Grade(2, 0.25)
        );

        $this->assessment->setGrades($grades);
        $this->assertFalse($this->assessment->validateGrades(), 'Unexpected validation result. Expected a not valid grade');
    }
} 