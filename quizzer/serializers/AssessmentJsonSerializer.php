<?php

class AssessmentJsonSerializer
{
    public static function serializeGrades($grades)
    {
        $scores = array();

        foreach ($grades as $studentId => $grade) {
            $score = array(
                "studentId" => $studentId,
                "value" => $grade->getGrade()
            );
            $scores[] = $score;
        }

        return '{"scores": ' . json_encode($scores, JSON_PRETTY_PRINT) . '}';
    }

    public static function serializeStatistics($statistics)
    {
        $items = array();

        foreach ($statistics as $questionId => $value) {
            $item = array(
                "questionId" => $questionId,
                "correctAnswers" => $value
            );
            $items[] = $item;
        }

        return '{"items": ' . json_encode($items, JSON_PRETTY_PRINT) . '}';
    }
} 