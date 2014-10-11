<?php

class TrueFalseQuestion extends Question
{
    private $correct;
    private $feedback;
    private $valueCorrect;
    private $valueIncorrect;

    function __construct($id, $text)
    {
        parent::__construct($id, $text);
    }

    protected function getScore(Answer $answer)
    {
        $score = 0;

        if (!empty($answer)) {
            $answerAsBoolean = strtolower($answer->getValue()) === 'true'? true : false;
            if ($answerAsBoolean == $this->correct) {
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

    public function getFeedback()
    {
        return $this->feedback;
    }

    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;
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