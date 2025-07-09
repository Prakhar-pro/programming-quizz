<?php
session_start();


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection and functions
    include "DB_Functions.php";

    // Connect to the server
    $conn = connectServer('localhost', 'root', '', 0);

    // Select the database
    selectDB($conn, "Quizzify", 0);

    // Get username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate if present
    $isValidAdmin=false;
    $isValidTeacher=false;
    $isValidStudent=false;

    $isValidAdmin = validateAdmin($conn, $username, $password);
    $isValidTeacher = validateTeacher($conn,$username, $password);
    $isValidStudent = validateStudent($conn,$username, $password);

    if ($isValidAdmin) {
        $admin = getAdminInfo($conn, $username);
        // Store admin information in the session
        $_SESSION["admin_id"] = $admin["admin_id"];
        $_SESSION["admin_name"] = $admin["admin_name"];

        // Redirect to the admin dashboard
        header("Location: admin/adminDashboard.php");
        exit();
    } else if($isValidTeacher){
        $teacher = getTeacherInfo($conn, $username);

        $_SESSION["teacher_id"]=$teacher["teacher_id"];
        $_SESSION["teacher_name"]=$teacher["teacher_name"];

        // Redirect to the teacher dashboard
        header("Location: teacher/teacherDashboard.php");
    }
     else if($isValidStudent){
        $student = getStudentInfo($conn, $username);

        $_SESSION["student_id"]=$student["student_id"];
        $_SESSION["student_name"]=$student["student_name"];

        // Redirect to the student dashboard
        header("Location: teacher/studentDashboard.php");
    }
    else{
        $error_message = "Invalid username or password.";
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
    <title>Login</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" class="form_login">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
</form>

<?php
if (isset($error_message)) {
    echo "<p class='error-message'>$error_message</p>";
}
?>

</body>
</html>
