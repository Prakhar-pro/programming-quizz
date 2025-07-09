<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["admin_id"])) {
    // Redirect to the login page if not logged in
    header("Location: ../login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    include "../DB_Functions.php";
    
    // Connect to the server
    $conn = connectServer('localhost', 'root', '', 0);
    
    // Select the database
    selectDB($conn, "Quizzify", 0);
    
    // Get data from the form
    $teacher_name = $_POST["teacher_name"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new teacher into the database
    $result=false;
    $result = addTeacher($conn, $teacher_name, $username, $hashedPassword);
    
    if ($result) {
        // Redirect to the admin dashboard after successful addition
        header("Location: teacherManage.php");
        exit();
    } else {
        $error_message = "Error adding teacher. Please try again.";
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
</head>
<body>

<!-- Add Teacher Form -->
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <h2>Add Teacher</h2>
    <label for="teacher_name">Teacher Name:</label>
    <input type="text" id="teacher_name" name="teacher_name" required>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Add Teacher</button>
</form>

<br>
<br>
<br>


<a href="adminDashboard.php"><button> to Admin Dashboard</button></a>
</body>
</html>
