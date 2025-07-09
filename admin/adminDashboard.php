<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["admin_id"])) {
    // Redirect to the login page if not logged in
    header("Location: ../login.php");
    exit();
}
 
include "../DB_Functions.php";

// Connect to the server
$conn = connectServer('localhost', 'root', '', 0);

// Select the database
selectDB($conn, "Quizzify", 0);

// Close the connection
mysqli_close($conn);
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

<header>
    <h1>Admin Dashboard</h1>
    
    <button style="float: left; background-color:darkorange" class="head-button" onclick="location.href='adminRegister.php'">Add Admin</button>
    <button class="head-button" onclick="location.href='../logout.php'">Logout</button>
    
    <p>Welcome, <?php echo $_SESSION["admin_name"]; ?>!</p>
    
    
    

</header>

<nav>
    
    <a href="teacherManage.php">Manage Teachers</a>
    <a href="studentManage.php">Manage Students</a>
    <a href="courseManage.php">Manage Courses</a>
</nav>

<main>
    <p>Welcome to the admin dashboard. Select an option from the navigation menu.</p>
</main>

</body>
</html>
