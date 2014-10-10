#Quizzer

[![Build Status](https://magnum.travis-ci.com/davidmogar/quizzer-php.svg?token=wmck5BREt8bmqUpsNF4v)](https://magnum.travis-ci.com/davidmogar/quizzer-php)

This is the PHP version of Quizzer, a simple application to parse JSON files with questons and answers of students to these questions to genereate and/or validate grades for all the students.

##Usage

Quizzer is a command line application and can be executed with the next options:
- `-a or --answers <arg>`: Sets the URL to the answers file.
- `-h or --help**`: Show the help message of the app.
- `-o or --output`: Indicate that we want to retrive the output of the action on the standard output.
- `-q or --questions <arg>`: Sets the URL to the questions file.
- `-t or --tests <arg>`: Validate assessments in a tests file.

##Web service

The app uses can be used as a web server if it is launched without arguments. In this mode you can navitate to [localhost:4567](http://localhost:4567) what would return the next form that can be used to generate grades.

![Quizzer](http://davidmogar.com/uploads/quizzer.png)


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
