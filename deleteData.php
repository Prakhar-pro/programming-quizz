<?php
    include "DB_Functions.php";

    //connect to server
    $conn = connectServer('localhost', 'root', '', 1);

    //Select DB 
    selectDB($conn, "Quizzify", 1);



	deleteDataFromTab($conn, "student_exam_attempt");
	deleteDataFromTab($conn, "student_question_attempt");
	deleteDataFromTab($conn, "options");
	deleteDataFromTab($conn, "questions");
	deleteDataFromTab($conn, "enrollments");
	deleteDataFromTab($conn, "courses");
	deleteDataFromTab($conn, "exams");
	deleteDataFromTab($conn, "students");
	deleteDataFromTab($conn, "teachers");
	deleteDataFromTab($conn, "admins");

    @mysqli_close($conn);