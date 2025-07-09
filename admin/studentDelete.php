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

// Check if the form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
    // Get student ID from the URL
    $student_id = $_GET["id"];

    // Delete student with his associated courses
    $result =  deleteStudent($conn, $student_id);

    if ($result) {
        // Redirect to the manage students page after successful deletion
        header("Location: studentManage.php");
        exit();
    } else {
        $error_message = "Deletion failed. Please try again.";
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
    <title>Delete Student</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h1>Delete Student</h1>

<?php if ($student) : ?>
    <!-- Display confirmation message and form for deletion -->
    <p>Are you sure you want to delete the student "<?php echo $student['student_name']; ?>"?</p>
    <form action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $student_id; ?>" method="post">
        <button type="submit" name="confirm_delete">Yes, Delete</button>
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
