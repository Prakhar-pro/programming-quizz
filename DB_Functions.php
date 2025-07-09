<?php
function connectServer($host,$log,$pass,$mess)
{ 
	$dbc=@mysqli_connect($host,$log,$pass) 
	  or die("connection error:".@mysqli_errno($dbc).
	         ": ".@mysqli_error($dbc)
			 );
	
	if($mess == 1)	print '<p>Successfully connected to MySQL!</p>';
	return $dbc;
}
/**=====================================================**/
function selectDB($dbc, $db, $mess)
{
	mysqli_select_db($dbc ,$db) 
	 or die ('<p style="color: red;">'.
			 "Could not select the database ".$db.
			 "because:<br/>".mysqli_error($dbc).
			 ".</p>");
	
	if ($mess == 1) echo "<p>The database $db has been selected.</p>";
}
/**=====================================================**/
function createDB($dbc,$db)
{
	$query= "CREATE DATABASE ".$db;
	mysqli_query($dbc,$query) 
	 or die('<p style="color: red;">'.
	        "Could not create the database ".
			$db." because:<br>".mysqli_error($dbc).
			".</p>");
		
	echo "<p>The database $db has been created!</p>";
}
/**=====================================================**/
function deleteDB($dbc,$db)
{
	$query= "DROP DATABASE IF EXISTS ".$db;
	mysqli_query($dbc,$query) 	 
     or die("DB Error: Could not delete the data base ".
		    $db."! <br>".@mysqli_error($dbc));
	
	print "<p> Data base $db deleted.</p>";
}
/**=====================================================**/
function createTable($dbc,$query,$Tab)
{
	// Execute the query:
	if (@mysqli_query($dbc,$query))
	{
		print "<p> The table $Tab has been created.</p>";
	}
	else
	{
		$str='<p style="color: red;">';
		$str.="Could not create the table $Tab because:<br>";
		$str.=mysqli_error($dbc);
		$str.=".</p><p>The query being run was:".$query."</p>";
		print $str;		    
	}
}
/**=====================================================**/
function deleteDataFromTab($dbc, $Tab)
{
	$query = "DELETE FROM ".$Tab;
    @mysqli_query($dbc,$query) 
    or die ("DB Error: Could not delete data from table $Tab! <br>".
		     @mysqli_error($dbc));
	
	print "<p> All data are deleted inside table $Tab.</p>";
}
/**=====================================================**/
function deleteTable($dbc, $Tab)
{
	$query = "DROP TABLE IF EXISTS ".$Tab;
    @mysqli_query($dbc,$query) 
      or die ("DB Error: Could not delete table person! <br>".
	          @mysqli_error($dbc));
	
	print "<p> Table $Tab deleted.</p>";
}
/**=====================================================**/
function insertDataToTab($dbc, $Tab, $query)
{
    @mysqli_query($dbc,$query) 
      or die ("DB Error: Could not insert $Tab! <br>".
			  @mysqli_error($dbc));
   
    print ("<h2 style = 'color: blue'> The $Tab was added successfully! </h2>");	
}
/**=====================================================**/
function executeQuery($dbc, $query)
{
    @mysqli_query($dbc,$query) 
      or die ("DB Error: Could not execute the query! <br>".
			  @mysqli_error($dbc));
   
    print ("<h2 style = 'color: blue'> The query was executed successfully! </h2>");	
}



////////////////////////////////////////

//----------Admin Functions-----------//

////////////////////////////////////////


//Validation for sign in

/**=======================================================**/
function validateAdmin($conn, $username, $password) {
    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT * FROM admins WHERE username = '$username';";
    $result = mysqli_query($conn, $query);

    if ($result && $admin = mysqli_fetch_assoc($result)) {
        // Use password_verify to check the password
        if (password_verify($password, $admin['password_hash'])) {
            // Admin is valid
            return true;
        }
    }

    // Admin is not valid
    return false;
}

function validateTeacher($conn, $username, $password) {
    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT * FROM teachers WHERE username = '$username';";
    $result = mysqli_query($conn, $query);

    if ($result && $teacher = mysqli_fetch_assoc($result)) {
        // Use password_verify to check the password
        if (password_verify($password, $teacher['password_hash'])) {
            // Teacher is valid
            return true;
        }
    }

    // Teacher is not valid
    return false;
}

function validateStudent($conn, $username, $password) {
    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT * FROM students WHERE username = '$username';";
    $result = mysqli_query($conn, $query);

    if ($result && $student = mysqli_fetch_assoc($result)) {
        // Use password_verify to check the password
        if (password_verify($password, $student['password_hash'])) {
            // Student is valid
            return true;
        }
    }

    // Student is not valid
    return false;
}

/**=======================================================**/


//Getting data for a user

function getAdminInfo($conn, $username) {
    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT * FROM admins WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

/**=======================================================**/

function getTeacherInfo($conn, $username) {
    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT * FROM teachers WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}
/**=======================================================**/

function getStudentInfo($conn, $username) {
    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT * FROM students WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

/**=======================================================**/

//Adding data

function addTeacher($conn, $name, $username, $password){

	$sqlInsertTeacher = "INSERT INTO teachers (teacher_name, username, password_hash) VALUES ('$name', '$username', '$password')";
    $result = mysqli_query($conn, $sqlInsertTeacher);
	return $result;
}

/**=======================================================**/

function addStudent($conn, $name, $username, $password){

	$sqlInsertStudent = "INSERT INTO students (student_name, username, password_hash) VALUES ('$name', '$username', '$password')";
    $result = mysqli_query($conn, $sqlInsertStudent);
	if ($result){
		return mysqli_insert_id($conn);
	}
	else{
		return false;
	}
}


/**=======================================================**/

// Function to get the list of teachers from the database
function getTeachersList($conn) {
    $query = "SELECT * FROM teachers";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return null;
}

/**=======================================================**/

function getStudentsList($conn) {
    $query = "SELECT * FROM students";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return null;
}

/**=======================================================**/

function getCoursesList($conn) {
    $query = "SELECT * FROM courses";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return null;
}

/**=======================================================**/
function addEnrollment($conn, $student_id, $course_id)
{
    $sql = "INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $student_id, $course_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/**=======================================================**/

//deleting student require deleting his questions and exam attempts in addition to enrollments associations
function deleteStudent($conn, $student_id) {
    // Check if the student exists
    $check_query = "SELECT * FROM students WHERE student_id = $student_id";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // Student exists, proceed with deletion
        // Disable foreign key checks to delete records with references
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

        // Delete from student_exam_attempt
        $delete_exam_attempt_query = "DELETE FROM student_exam_attempt WHERE student_id = $student_id";
        mysqli_query($conn, $delete_exam_attempt_query);

        // Delete from student_question_attempt
        $delete_question_attempt_query = "DELETE FROM student_question_attempt WHERE student_id = $student_id";
        mysqli_query($conn, $delete_question_attempt_query);

        // Now delete the student
        $delete_student_query = "DELETE FROM students WHERE student_id = $student_id";
        $result = mysqli_query($conn, $delete_student_query);

        // Enable foreign key checks back
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

        return $result;
    } else {
        // Student does not exist
        return false;
    }
}



/**=======================================================**/

function deleteTeacher($conn, $teacher_id) {
    // Check if the teacher exists
    $check_query = "SELECT * FROM teachers WHERE teacher_id = $teacher_id";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // Teacher exists, proceed with deletion
        // Disable foreign key checks to delete records with references
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

        // Delete related records from other tables
        $delete_exams_query = "DELETE FROM exams WHERE Teacher_ID = $teacher_id";
        mysqli_query($conn, $delete_exams_query);

        // Now delete the teacher
        $delete_teacher_query = "DELETE FROM teachers WHERE teacher_id = $teacher_id";
        $result = mysqli_query($conn, $delete_teacher_query);

        // Enable foreign key checks back
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

        return $result;
    } else {
        // Teacher does not exist
        return false;
    }
}

/**=======================================================**/

function deleteCourse($conn, $course_id){

    $sql = "Delete from enrollments where course_id = $course_id";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        $sqlDeleteCourse = "DELETE FROM courses WHERE course_id = $course_id"; 
        $result= mysqli_query($conn, $sqlDeleteCourse);
    }
        
    return $result;
}

///////////////////////////////////
///////////////////////////////////
///////////////////////////////////


