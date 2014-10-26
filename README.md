#Quizzer

[![Build Status](https://travis-ci.org/davidmogar/quizzer-php.svg)](https://travis-ci.org/davidmogar/quizzer-php)

This is the PHP version of Quizzer, a simple application to parse JSON files with questions and answers of students to these questions to genereate and/or validate grades for all the students.

##Usage

Quizzer is a command line application and can be executed with the next options:
- `-a <arg>`: Sets the URL to the answers file.
- `-h`: Show the help message of the app.
- `-o <arg>`: Generate output in the specified format (json or xml)"
- `-q <arg>`: Sets the URL to the questions file.
- `-s`: Show questions statistics.
- `-t <arg>`: Validate assessments in a tests file.

As an example, the arguments `-q questions.json -a answers.json -o xml -s` will generate grades and statistics for the given assessment data and will show the result as xml files in the standard output.

##Web service

Along with the app there is a webpage (index.html) that contains a form that can be used to generate grades. The input is sent to quizzer.php to retrieve the result.

![Quizzer](http://davidmogar.com/uploads/github/quizzer.png)


##JSON files

Quizzer thre kind of files: questions, answers and grades files. The next sections show an example of this files.

###Questions
Questions files are used to store all the questions of an assessment. There are two types of questions: Multichoice and True/False questions.

```json
{ "questions": 
  [
    { "type": "multichoice", 
      "id" : 1,
      "questionText": "Scala fue creado por...",
      "alternatives":
      [ 
        { "text": "Martin Odersky", "code": 1, "value": 1 },
        { "text": "James Gosling", "code": 2, "value": -0.25 },
        { "text": "Guido van Rossum", "code": 3, "value": -0.25 }
      ]
    },
    { "type" : "truefalse",
      "id" : 2,
      "questionText": "El creador de Ruby es Yukihiro Matsumoto",
      "correct": true,
      "valueOK": 1,
      "valueFailed": -0.25,
      "feedback": "Yukihiro Matsumoto es el principal desarrollador de Ruby desde 1996" 
    }
  ]
}
```

###Answers
Answers file store all the answers submited by the students.

```json
{ "items": 
  [
    { "studentId": 234 ,
      "answers": 
      [
        { "question" : 1, "value": 1 },
        { "question" : 2, "value": false }
      ] 
    },
    { "studentId": 245 ,      
      "answers": 
      [ 
        { "question" : 1, "value": 1 },
        { "question" : 2, "value": true }
      ] 
    }, 
    { "studentId": 221 ,      
      "answers": 
      [
        { "question" : 1, "value": 2 },
        { "question" : 2, "value": true }
      ] 
    }
  ]
}
```

###Grades
Grades files store the grade obtained by an student in the assessment.

```json
{ "scores": 
  [
    { "studentId": 234, "value": 0.75 } ,
    { "studentId": 245, "value": 2.0 } ,
    { "studentId": 221, "value": 0.75 }
  ]
}
```

###Statistics
Quizzer can generate statistics for the current assessment, showing how many correct or partially correct answers received the assessment's questions. The output would be similar to the next json file:
```json
{
  "items":
  [
    {
      "questionId": 1,
      "correctAnswers": 2
    },
    {
      "questionId": 2,
      "correctAnswers": 2
    }
  ]
}
```

###Tests
There is an extra file used to test a bunch of assessments at the same time. You can check the structure of this file below:

```json
{ "tests": 
  [
    { "type": "score", 
      "quizz" : "http://domain.com/Ejercicios/questions.json",
      "assessment": "http://domain.com/Ejercicios/answers.json",
      "scores": "http://domain.com/Ejercicios/scores.json",
    },
    { "type": "score", 
      "quizz" : "http://domain.com/Ejercicios/questions.json",
      "assessment": "http://domain.com/Ejercicios/answers.json",
      "scores": "http://domain.com/Ejercicios/scores.json",
    }
  ]
}
```
