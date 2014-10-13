<?php

class AssessmentXmlSerializer
{
    public static function serializeGrades($grades)
    {
        $result = "<scores>\n";

        foreach ($grades as $studentId => $grade) {
            $result .= "\t<score>\n\t\t<studentId>" . $studentId . "</studentId>\n";
            $result .= "\t\t<value>" . $grade->getGrade() . "</value>\n\t</score>\n";
        }

        return $result . "</scores>";
    }

    public static function serializeStatistics($statistics)
    {
        $result = "<statistics>\n";

        foreach ($statistics as $questionId => $value) {
            $result .= "\t<item>\n\t\t<questionId>" . $questionId . "</questionId>\n";
            $result .= "\t\t<correctAnswers>" . $value . "</correctAnswrs>\n\t</item>\n";
        }

        return $result . "</statistics>";
    }
}