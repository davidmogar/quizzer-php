<?php

class Answer
{
    private $questionId;
    private $value;

    function __construct($questionId, $value)
    {
        $this->questionId = $questionId;
        $this->value = $value;
    }

    public function getQuestionId()
    {
        return $this->questionId;
    }

    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
} 