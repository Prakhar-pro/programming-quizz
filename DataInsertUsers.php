<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title> USERS ADD </title>
</head>

<body style="background-color: #F0E68C">

	<?php
	include "DB_Functions.php";

	$conn = connectServer('localhost', 'root', '', 1); //connect to server	
	selectDB($conn, "Quizzify", 1); //Select DB

	$password=password_hash("admin3password", PASSWORD_DEFAULT);
	//Insert Admin
	$sqlInsertAdmin = "INSERT INTO admins (admin_name, username, password_hash) VALUES ('Admin 3', 'admin3', '$password')";
	insertDataToTab($conn, 'admins', $sqlInsertAdmin);

	//Insert Teacher
	$sqlInsertTeacher = "INSERT INTO teachers (teacher_name, username, password_hash) VALUES ('Teacher 3', 'teacher3', 'teacher3password')";
	insertDataToTab($conn, 'teachers', $sqlInsertTeacher);

	//Insert Student
	$sqlInsertStudent = "INSERT INTO students (student_name, username, password_hash) VALUES ('Student 3', 'student3', 'student3password')";
	insertDataToTab($conn, 'students', $sqlInsertStudent);
	
	$studentId= mysqli_insert_id($conn);
	
	$sqlInsertExam = "INSERT INTO exams (teacher_id, exam_name, start_time, end_time) VALUES (1, 'Exam 3', '2023-01-03 08:00:00', '2023-01-03 10:00:00')";
	insertDataToTab($conn, 'exams', $sqlInsertExam);
	
	// Get the auto-incremented exam_id from the last insert
	$examId = mysqli_insert_id($conn);
	
	//Insert Course
	$sqlInsertCourse = "INSERT INTO courses (course_id, course_name, teacher_id) VALUES (1, 'PHP', 1)";
	insertDataToTab($conn, 'courses', $sqlInsertCourse);
	

	$sqlInsertEnrollment = "INSERT INTO enrollments (student_id, course_id) VALUES (1, 1)";
	insertDataToTab($conn, 'enrollements', $sqlInsertEnrollment);


	// Insert data into questions table with the correct exam_id
	$sqlInsertQuestion = "INSERT INTO questions (exam_id, mark, question_text) VALUES ($examId, 5, 'What is the capital of Italy?')";
	insertDataToTab($conn, 'questions', $sqlInsertQuestion);

	//Insert Options
	$sqlInsertOption1 = "INSERT INTO options (question_id, option_text, is_correct) VALUES (1, 'Rome', 1)";
	insertDataToTab($conn, 'options', $sqlInsertOption1);

	$sqlInsertOption2 = "INSERT INTO options (question_id, option_text, is_correct) VALUES (1, 'Madrid', 0)";
	insertDataToTab($conn, 'options', $sqlInsertOption2);

	$sqlInsertOption3 = "INSERT INTO options (question_id, option_text, is_correct) VALUES (1, 'Athens', 0)";
	insertDataToTab($conn, 'options', $sqlInsertOption3);


	//Insert Question Attempt
	$sqlInsertStudentQuestionAttempt = "INSERT INTO student_question_attempt (student_id, question_id, selected_option_id) VALUES (1, 1, 1)";
	insertDataToTab($conn, 'student_question_attempt', $sqlInsertStudentQuestionAttempt);

	//Insert Exam Attempt
	$sqlInsertStudentExamAttempt = "INSERT INTO student_exam_attempt (student_id, exam_id, score) VALUES ($studentId, $examId, 4)";
	insertDataToTab($conn, 'student_exam_attempt', $sqlInsertStudentExamAttempt);
	



	




	@mysqli_close($conn); // Close the connection.
	?>
</body>

</html>