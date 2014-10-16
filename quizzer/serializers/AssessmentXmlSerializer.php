<?php

class AssessmentXmlSerializer
{
    /**
     * Returns an string with the representation of the grades in XML format.
     *
     * @param $grades grades to serialize
     * @return string an string with the representation in the desired format
     */
    public static function serializeGrades($grades)
    {
        $result = "<scores>\n";

        foreach ($grades as $studentId => $grade) {
            $result .= "\t<score>\n\t\t<studentId>" . $studentId . "</studentId>\n";
            $result .= "\t\t<value>" . $grade->getGrade() . "</value>\n\t</score>\n";
        }

        return $result . "</scores>";
    }

    /**
     * Returns an string with the representation of the statistics in XML format.
     *
     * @param $statistics statistics to serialize
     * @return string an string with the representation in the desired format
     */
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