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
    $course_id = $_GET["id"];

    // Delete student with his associated courses
    $result =  deleteCourse($conn, $course_id);

    if ($result) {
        // Redirect to the manage students page after successful deletion
        header("Location: studentManage.php");
        exit();
    } else {
        $error_message = "Deletion failed. Please try again.";
    }
}

// Fetch the current student information
$course_id = $_GET["id"];
$fetch_course_query = "SELECT * FROM courses WHERE course_id = $course_id";
$course_result = mysqli_query($conn, $fetch_course_query);

if ($course_result && mysqli_num_rows($course_result) > 0) {
    $course = mysqli_fetch_assoc($course_result);
} else {
    // Redirect to manage students page if student not found
    header("Location: courseManage.php");
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
    <title>Delete Course</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h1>Delete Course</h1>

<?php if ($course) : ?>
    <!-- Display confirmation message and form for deletion -->
    <p>Are you sure you want to delete the student "<?php echo $course['course_name']; ?>"?</p>
    <form action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $course_id; ?>" method="post">
        <button type="submit" name="confirm_delete">Yes, Delete</button>
    </form>
<?php else : ?>
    <p>Course not found.</p>
<?php endif; ?>

<br>
<br>
<br>


<a href="courseManage.php"><button>Manage Students</button></a>

</body>
</html>
