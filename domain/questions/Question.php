<?php

abstract class Question
{
    protected $text;
    protected $id;

    function __construct($id, $text)
    {
        $this->id = $id;
        $this->text = $text;
    }

    abstract protected function getScore(Answer $answer);

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