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

// Check if the form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
    // Get teacher ID from the URL
    $teacher_id = $_GET["id"];

    // Delete teacher
    $result=deleteTeacher($conn, $teacher_id);

    if ($result) {
        // Redirect to the manage teachers page after successful deletion
        header("Location: teacherManage.php");
        exit();
    } else {
        $error_message = "Deletion failed. Please try again.";
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
    <title>Delete Teacher</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h1>Delete Teacher</h1>

<?php if ($teacher) : ?>
    <!-- Display confirmation message and form for deletion -->
    <p>Are you sure you want to delete the teacher "<?php echo $teacher['teacher_name']; ?>"?</p>
    <form action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $teacher_id; ?>" method="post">
        <button type="submit" name="confirm_delete">Yes, Delete</button>
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
