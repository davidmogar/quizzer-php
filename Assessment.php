<?php

class Assessment
{
    private $questions;
    private $answers;
    private $grades;

    function __construct()
    {
        $this->questions = array();
        $this->answers = array();
        $this->grades = array();
    }

    public function calculateGrades()
    {

    }

    public function calculateStudentsGrade($studentId)
    {

    }

    public function validateGrade(Grade $grade)
    {
        $computedGrade = 0;
    }

    public function validaGrades()
    {
        $valid = true;

        foreach ($this->grades as $key => $value) {
            if ($valid = $this->validaGrade($value)) {
                break;
            }
        }

        return $valid;
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function setQuestions($questions)
    {
        if (is_array($questions)) {
            $this->questions = $questions;
        }
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function setAnswers($answers)
    {
        if (is_array($answers)) {
            $this->answers = $answers;
        }
    }

    public function getGrades()
    {
        return $this->grades;
    }

    public function setGrades($grades)
    {
        if (is_array($grades)) {
            $this->grades = $grades;
        }
    }
} 