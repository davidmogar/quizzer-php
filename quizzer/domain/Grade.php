<?php

class Grade
{
    private $studentId;
    private $grade;

    function __construct($studentId, $grade)
    {
        $this->grade = $grade;
        $this->studentId = $studentId;
    }

    public function getGrade()
    {
        return $this->grade;
    }

    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    public function getStudentId()
    {
        return $this->studentId;
    }

    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
    }
} 