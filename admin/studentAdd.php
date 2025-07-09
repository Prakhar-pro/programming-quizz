<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["admin_id"])) {
    // Redirect to the login page if not logged in
    header("Location: ../login.php");
    exit();
}
include '../DB_Functions.php';
    
    $conn=connectServer('localhost','root','',0);
    selectDB($conn, "Quizzify", 0);
    $sqlGetCourses="SELECT course_id, course_name FROM courses";

    $result=@mysqli_query($conn,$sqlGetCourses);

    if($result){
        $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else{
        echo "Error: ".mysqli_error($dbc);
    }
if($_SERVER["REQUEST_METHOD"]=="POST"){

    
    // Get data from the form
    $student_name = $_POST["student_name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    //getting the selected courses
    $selectedCourses= $_POST["course_ids"];
    
    // Insert new teacher into the database
    $result=false;

    //Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $result = addStudent($conn, $student_name, $username, $hashedPassword);

    foreach($selectedCourses as $course){
        addEnrollment($conn, $result, $course);
    }
    
    if ($result) {
        // Redirect to the admin dashboard after successful addition
        header("Location: studentManage.php");
        exit();
    } else {
        $error_message = "Error adding Student. Please try again.";
    }
    
    // Close the connection
    mysqli_close($conn);
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
select {
    /* Basic styling */
    width: 150px; /* Adjust width as needed */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    font-size: 16px;
  
    /* Arrow styling */
    appearance: none; /* Remove default arrow */
    -webkit-appearance: none;
    -moz-appearance: none;

    background-repeat: no-repeat;
    background-position: right 10px center;
    cursor: pointer;
    background-size: contain;
  }
  
  select option {
    /* Option styling */
    padding: 5px 10px;
    color: #333;
  }
  
  select option:hover {
    /* Hover effect */
    background-color: #f2f2f2;
  }

    </style>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <h2>Add Student and Enroll in Courses</h2>
    <label for="student_name">Student Name:</label>
    <input type="text" id="student_name" name="student_name" required>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <!-- Selecting from all available courses -->
    <p>To select multiple courses please hold ctrl while selecting</p>
    <label for="course_ids">Select Courses:</label>
        <select name="course_ids[]" id="course_ids" multiple required>
            <?php
            
            foreach ($courses as $course) :
            ?>
                <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
            <?php endforeach; ?>
        </select>

    <button type="submit">Add Student</button>
</form>

<br>
<br>
<br>


<a href="adminDashboard.php"><button> to Admin Dashboard</button></a>
</body>
</html>
