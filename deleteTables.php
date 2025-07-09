<?php
include "DB_Functions.php";

// Connect to the server
$conn = connectServer('localhost', 'root', '', 1);

// Select the database
selectDB($conn, "Quizzify", 1);

// Call the deleteTable function to delete tables

deleteTable($conn, "student_exam_attempt");
deleteTable($conn, "student_question_attempt");
deleteTable($conn, "options");
deleteTable($conn, "text_answers");
deleteTable($conn, "questions");
deleteTable($conn, "enrollments");
deleteTable($conn, "courses");
deleteTable($conn, "exams");
deleteTable($conn, "students");
deleteTable($conn, "teachers");
deleteTable($conn, "admins");
// Close the connection
mysqli_close($conn);
?>
