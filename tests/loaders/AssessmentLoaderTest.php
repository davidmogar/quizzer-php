<?php

require_once 'quizzer/loaders/AssessmentLoader.php';

class AssessmentLoaderTest extends PHPUnit_Framework_TestCase {

    private static $questionsUrl = 'http://di002.edv.uniovi.es/~labra/cursos/MIW/POO/Curso1415/Ejercicios/quizz1.json';
    private static $answersUrl = 'http://di002.edv.uniovi.es/~labra/cursos/MIW/POO/Curso1415/Ejercicios/assessment1.json';
    private static $gradesUrl = 'http://di002.edv.uniovi.es/~labra/cursos/MIW/POO/Curso1415/Ejercicios/scores11.json';

    public function testLoadAssessmentFromUrls() {
        AssessmentLoader::loadAssessmentFromUrls(self::$questionsUrl, self::$answersUrl, self::$gradesUrl);
    }
}
 