<?php

require_once 'Question.php';

class NumericalQuestion extends Question
{
    private $correct;
    private $valueCorrect;
    private $valueIncorrect;

    function __construct($id, $text)
    {
        parent::__construct($id, $text);
    }

    public function getScore(Answer $answer)
    {
        $score = 0;

        if (!empty($answer)) {
            if ($answer->getValue() == $this->correct) {
                $score = $this->valueCorrect;
            } else {
                $score = $this->valueIncorrect;
            }
        }

        return $score;
    }

    public function getCorrect()
    {
        return $this->correct;
    }

    public function setCorrect($correct)
    {
        $this->correct = $correct;
    }

    public function getValueCorrect()
    {
        return $this->valueCorrect;
    }

    public function setValueCorrect($valueCorrect)
    {
        $this->valueCorrect = $valueCorrect;
    }

    public function getValueIncorrect()
    {
        return $this->valueIncorrect;
    }

    public function setValueIncorrect($valueIncorrect)
    {
        $this->valueIncorrect = $valueIncorrect;
    }
} 