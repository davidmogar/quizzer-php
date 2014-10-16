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

    /**
     * Calculate the grades of this assessment.
     */
    public function calculateGrades()
    {
        $this->grades = array();

        foreach ($this->answers as $key => $value) {
            $this->grades[$key] = new Grade($key, $this->calculateStudentGrade($key));
        }
    }

    /**
     * Calculates the grade of a given student.
     *
     * @param $studentId id of the student
     * @return double calculated grade of the student
     */
    public function calculateStudentGrade($studentId)
    {
        $grade = 0;

        if (isset($this->answers[$studentId])) {
            foreach ($this->answers[$studentId] as $answer) {
                $questionId = $answer->getQuestionId();

                if (isset($this->questions[$questionId])) {
                    $grade += $this->questions[$questionId]->getScore($answer);
                }
            }
        }

        return $grade;
    }

    /**
     * Returns an array mapping each question id with the number of correct answers of that question.
     *
     * @return array an array with the questions' statistics
     */
    public function getStatistics()
    {
        $statistics = array();

        foreach ($this->answers as $key => $value) {
            foreach ($this->answers[$key] as $answer) {
                $questionId = $answer->getQuestionId();

                if (isset($this->questions[$questionId])) {
                    if ($this->questions[$questionId]->getScore($answer) > 0) {
                        if (isset($statistics[$questionId])) {
                            $statistics[$questionId] += 1;
                        } else {
                            $statistics[$questionId] = 1;
                        }
                    }
                }
            }
        }

        return $statistics;
    }

    /**
     * Validates the grade received as argument, checking that the value stored correspond to the grade obtained by
     * the student.
     *
     * @param Grade $grade grade to validate
     * @return bool true if the grade is valid, false otherwise
     */
    public function validateGrade(Grade $grade)
    {
        $valid = false;

        if (!empty($grade)) {
            $valid = $grade->getGrade() == $this->calculateStudentGrade($grade->getStudentId());
        }

        return $valid;
    }

    /**
     * Validate all the grades of this assessment, checking that all the values stored in each grade correspond to
     * the actual grade obtained by the students.
     *
     * @return bool true if all the grades are valid, false otherwise
     */
    public function validateGrades()
    {
        $valid = true;

        foreach ($this->grades as $key => $value) {
            if (!($valid = $this->validateGrade($value))) {
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