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
    $sqlGetTeachers="SELECT teacher_id, teacher_name FROM teachers";

    $result=@mysqli_query($conn,$sqlGetTeachers);

    if($result){
        $teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else{
        echo "Error: ".mysqli_error($dbc);
    }
    
    if($_SERVER['REQUEST_METHOD']=='POST'){

        $courseName= $_POST["course_name"];
        $courseTeacher= $_POST["teacher"];

        $sqlSaveCourse="INSERT INTO courses(course_name, teacher_id) VALUES('$courseName', $courseTeacher);";

        $result=@mysqli_query($conn, $sqlSaveCourse);

        if($result){
            header("Location: courseManage.php");
            exit();
        }
        else{
            $error_message = "Error adding teacher. Please try again.";
        }

        mysqli_close($conn);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
select {
    
    width: 150px; 
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    font-size: 16px;
  
    appearance: none; 
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("../css/arrow-down-icon.png");
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
    <h1>Add Course</h1>

    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <label for="course_name">Course Name</label>
        <input name="course_name" id="course_name" required>

        <select name="teacher" id="teacher" required>
            <?php foreach($teachers as $teacher) {
                echo '<option value="'.$teacher['teacher_id'].'">'.$teacher['teacher_name'].'</option>';
            } ?>
        </select>
            
        <br>

        <input name="submit" type="submit" value="Add">
        
    </form>
</body>
</html>