
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["admin_id"])) {
    // Redirect to the login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Include necessary functions and database connection
include "../DB_Functions.php";

// Connect to the server
$conn = connectServer('localhost', 'root', '', 0);

// Select the database
selectDB($conn, "Quizzify", 0);

// Check if the form is submitted for updating
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_student"])) {
    $new_student_name = $_POST["new_student_name"];
    $new_username = $_POST["new_username"];
    $new_password=$_POST["new_password"];

    // Get student ID from the URL
    $student_id = $_GET["id"];

    // Hash the password
    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

    // Update student information
    $update_query = "UPDATE students SET student_name = '$new_student_name', username = '$new_username', password_hash='$hashedPassword' WHERE student_id = $student_id";
    $result = mysqli_query($conn, $update_query);

    if ($result) {
        // Redirect to the manage students page after successful update
        header("Location: studentManage.php");
        exit();
    } else {
        $error_message = "Update failed. Please try again.";
    }
}

// Fetch the current student information
$student_id = $_GET["id"];
$fetch_student_query = "SELECT * FROM students WHERE student_id = $student_id";
$student_result = mysqli_query($conn, $fetch_student_query);

if ($student_result && mysqli_num_rows($student_result) > 0) {
    $student = mysqli_fetch_assoc($student_result);
} else {
    // Redirect to manage students page if student not found
    header("Location: studentManage.php");
    exit();
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    <h1>Update Student</h1>

    <?php if ($student) : ?>
        <!-- Display the form for updating student information -->
        <form action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $student_id; ?>" method="post">
            <label for="new_student_name">New Student Name:</label>
            <input type="text" id="new_student_name" name="new_student_name" value="<?php echo $student['student_name']; ?>" required>

            <label for="new_username">New Username:</label>
            <input type="text" id="new_username" name="new_username" value="<?php echo $student['username']; ?>" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" value="<?php echo $student['password_hash']; ?>" required>


            <button type="submit" name="update_student">Update Student</button>
        </form>
    <?php else : ?>
        <p>Student not found.</p>
    <?php endif; ?>

    <br>
    <br>
    <br>

    <a href="studentManage.php"><button>Manage Students</button></a>

</body>

</html>
