<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=”http://www.w3.org/1999/ xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Create a Table</title>
</head>

<body>
    <?php
    include "DB_Functions.php";

    //connect to server
    $dbc = connectServer('localhost', 'root', '', 1);

    //Select DB 
    selectDB($dbc, "Quizzify", 1);

    //Create table
    $sqlCreateAdminsTable = "
    CREATE TABLE IF NOT EXISTS admins (
        admin_name VARCHAR(50) NOT NULL,
        admin_id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL
    )";

    $sqlCreateTeachersTable = "
    CREATE TABLE IF NOT EXISTS teachers (
        teacher_name VARCHAR(50) NOT NULL,
        teacher_id INT PRIMARY KEY AUTO_INCREMENT,
        admin_id INT,
        username VARCHAR(50) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        FOREIGN KEY (admin_id) REFERENCES admins(admin_id)
    )";

    $sqlCreateStudentsTable = "
    CREATE TABLE IF NOT EXISTS students (
        student_name VARCHAR(50) NOT NULL,
        student_id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL
    )";

    $sqlCreateExamsTable = "
    CREATE TABLE Exams (
        Exam_ID INT PRIMARY KEY AUTO_INCREMENT,
        Teacher_ID INT,
        Exam_Name VARCHAR(100) NOT NULL,
        Start_Time TIMESTAMP,
        End_Time DATETIME DEFAULT NULL, -- or TIMESTAMP DEFAULT NULL
        FOREIGN KEY (Teacher_ID) REFERENCES Teachers(Teacher_ID)
    )";

    $sqlCreateQuestionsTable = "
    CREATE TABLE IF NOT EXISTS questions (
        question_id INT PRIMARY KEY AUTO_INCREMENT,
        exam_id INT,
        mark INT,
        question_text VARCHAR(255) NOT NULL,
        FOREIGN KEY (exam_id) REFERENCES exams(exam_id)
    )";

    $sqlCreateOptionsTable = "
    CREATE TABLE IF NOT EXISTS options (
        option_id INT PRIMARY KEY AUTO_INCREMENT,
        question_id INT,
        option_text VARCHAR(255) NOT NULL,
        is_correct BOOLEAN NOT NULL,
        FOREIGN KEY (question_id) REFERENCES questions(question_id)
    )";

    $sqlCreateTextAnswerTable = "
    CREATE TABLE IF NOT EXISTS text_answers (
        answer_id INT PRIMARY KEY AUTO_INCREMENT,
        question_id INT,
        answer_text TEXT NOT NULL,
        FOREIGN KEY (question_id) REFERENCES questions(question_id)
    );";

    $sqlCreateStudentExamAttemptTable = "
    CREATE TABLE IF NOT EXISTS student_exam_attempt (
        student_id INT,
        exam_id INT,
        score INT,
        PRIMARY KEY (student_id, exam_id),
        FOREIGN KEY (student_id) REFERENCES students(student_id),
        FOREIGN KEY (exam_id) REFERENCES exams(exam_id)
    )";

    $sqlCreateStudentQuestionAttemptTable = "
    CREATE TABLE IF NOT EXISTS student_question_attempt (
        student_id INT,
        question_id INT,
        selected_option_id INT,
        PRIMARY KEY (student_id, question_id),
        FOREIGN KEY (student_id) REFERENCES students(student_id),
        FOREIGN KEY (question_id) REFERENCES questions(question_id),
        FOREIGN KEY (selected_option_id) REFERENCES options(option_id)
    )";
    
    $sqlCreateCoursesTable = "
    CREATE TABLE IF NOT EXISTS courses (
        course_id INT PRIMARY KEY AUTO_INCREMENT,
        course_name VARCHAR(100) NOT NULL,
        teacher_id INT,
        FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
    )";

    $sqlCreateEnrollmentsTable = "CREATE TABLE IF NOT EXISTS enrollments (
        enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
        student_id INT,
        course_id INT,
        FOREIGN KEY (student_id) REFERENCES students(student_id),
        FOREIGN KEY (course_id) REFERENCES courses(course_id)
    );";
    
    // Execute table creation queries
    createTable($dbc, $sqlCreateAdminsTable, "Admins");
    createTable($dbc, $sqlCreateTeachersTable, "Teachers");
    createTable($dbc, $sqlCreateStudentsTable, "Students");
    createTable($dbc, $sqlCreateExamsTable, "Exams");
    createTable($dbc, $sqlCreateQuestionsTable, "Questions");
    createTable($dbc, $sqlCreateOptionsTable, "Options");
    createTable($dbc, $sqlCreateTextAnswerTable, "Text_Answer");
    createTable($dbc, $sqlCreateStudentExamAttemptTable, "Student_Exam_Attempt");
    createTable($dbc, $sqlCreateStudentQuestionAttemptTable, "Student_Question_Attempt");
    createTable($dbc, $sqlCreateCoursesTable, "Courses");
    createTable($dbc, $sqlCreateEnrollmentsTable, "Enrollments");

    echo "Tables created successfully";

    mysqli_close($dbc); // Close the connection.


    ?>
</body>

</html>