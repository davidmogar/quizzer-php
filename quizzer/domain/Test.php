<?php

class Test
{
    private $questionsUrl;
    private $answersUrl;
    private $gradesUrl;

    function __construct($questionsUrl, $answersUrl, $gradesUrl)
    {
        $this->questionsUrl = $questionsUrl;
        $this->answersUrl = $answersUrl;
        $this->gradesUrl = $gradesUrl;
    }

    public function getAnswersUrl()
    {
        return $this->answersUrl;
    }

    public function setAnswersUrl($answersUrl)
    {
        $this->answersUrl = $answersUrl;
    }

    public function getGradesUrl()
    {
        return $this->gradesUrl;
    }

    public function setGradesUrl($gradesUrl)
    {
        $this->gradesUrl = $gradesUrl;
    }

    public function getQuestionsUrl()
    {
        return $this->questionsUrl;
    }

    public function setQuestionsUrl($questionsUrl)
    {
        $this->questionsUrl = $questionsUrl;
    }
} 