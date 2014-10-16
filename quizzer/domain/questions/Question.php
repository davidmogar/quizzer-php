<?php

require_once 'quizzer/domain/Answer.php';

abstract class Question
{
    protected $text;
    protected $id;

    function __construct($id, $text)
    {
        $this->id = $id;
        $this->text = $text;
    }

    /**
     * Calculates the score obtained by an student given its answer
     *
     * @param Answer $answer answer of the student to this question
     * @return mixed calculated score
     */
    abstract public function getScore(Answer $answer);

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($questionText)
    {
        $this->text = $questionText;
    }
}