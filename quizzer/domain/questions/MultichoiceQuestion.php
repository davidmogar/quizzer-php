<?php

require_once 'Question.php';

class MultichoiceQuestion extends Question
{
    private $alternatives;

    function __construct($id, $text)
    {
        parent::__construct($id, $text);

        $this->alternatives = array();
    }

    function addAlternative($id, $text, $value)
    {
        $this->alternatives[$id] = new Alternative($id, $text, $value);
    }

    public function getScore(Answer $answer)
    {
        $score = 0;

        if (!empty($answer)) {
            $answerValue = $answer->getValue();

            if (isset($this->alternatives[$answerValue])) {
                $score = $this->alternatives[$answerValue]->value;
            }
        }

        return $score;
    }
}

class Alternative
{
    var $id;
    var $text;
    var $value;

    function __construct($id, $text, $value)
    {
        $this->id = $id;
        $this->text = $text;
        $this->value = $value;
    }
}

