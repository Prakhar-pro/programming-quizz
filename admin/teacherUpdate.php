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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_teacher"])) {
    $new_teacher_name = $_POST["new_teacher_name"];
    $new_username = $_POST["new_username"];
    $new_password = $_POST["new_password"];

    // Hash the password
    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

    // Get teacher ID from the URL
    $teacher_id = $_GET["id"];

    // Update teacher information
    $update_query = "UPDATE teachers SET teacher_name = '$new_teacher_name', username = '$new_username', password_hash = '$hashedPassword' WHERE teacher_id = $teacher_id";
    
    $result = mysqli_query($conn, $update_query);

    if ($result) {
        // Redirect to the manage teachers page after successful update
        header("Location: teacherManage.php");
        exit();
    } else {
        $error_message = "Update failed. Please try again.";
    }
}

// Fetch the current teacher information
$teacher_id = $_GET["id"];
$fetch_teacher_query = "SELECT * FROM teachers WHERE teacher_id = $teacher_id";
$teacher_result = mysqli_query($conn, $fetch_teacher_query);

if ($teacher_result && mysqli_num_rows($teacher_result) > 0) {
    $teacher = mysqli_fetch_assoc($teacher_result);
} else {
    // Redirect to manage teachers page if teacher not found
    header("Location: teacherManage.php");
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
    <title>Update Teacher</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h1>Update Teacher</h1>

<?php if ($teacher) : ?>
    <!-- Display the form for updating teacher information -->
    <form action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $teacher_id; ?>" method="post">
        <label for="new_teacher_name">New Teacher Name:</label>
        <input type="text" id="new_teacher_name" name="new_teacher_name" value="<?php echo $teacher['teacher_name']; ?>" required>

        <label for="new_username">New Username:</label>
        <input type="text" id="new_username" name="new_username" value="<?php echo $teacher['username']; ?>" required>
        
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" value="<?php echo $teacher['password'] ?? ''; ?>" required>


        <button type="submit" name="update_teacher">Update Teacher</button>
    </form>
<?php else : ?>
    <p>Teacher not found.</p>
<?php endif; ?>

<br>
<br>
<br>

<a href="adminDashboard.php"><button> to Admin Dashboard</button></a>

</body>
</html>
