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
        $this->grades = array();

        foreach($this->answers as $key => $value) {
            $this->grades[$key] = new Grade($key, $this->calculateStudentGrade($key));
        }
    }

    public function calculateStudentGrade($studentId)
    {
        $grade = 0;

        if (isset($this->answers[$studentId])) {
            foreach($this->answers[$studentId] as $answer) {
                $questionId = $answer->getQuestionId();

                if (isset($this->questions[$questionId])) {
                    $grade += $this->questions[$questionId]->getScore($answer);
                }
            }
        }

        return $grade;
    }

    public function validateGrade(Grade $grade)
    {
        $valid = false;

        if (!empty($grade)) {
            $valid = $grade->getGrade() == $this->calculateStudentGrade($grade->getStudentId());
        }

        return $valid;
    }

    public function validateGrades()
    {
        $valid = true;

        foreach ($this->grades as $key => $value) {
            $valid = $this->validateGrade($value);
            if (!$valid) {
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