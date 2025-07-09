<?php
session_start();

include "../DB_Functions.php";

// Check if the admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}



$conn = connectServer('localhost', 'root', '', 0);
selectDB($conn, "Quizzify", 0);

// Fetch and display list of students
$students = getStudentsList($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h1>Manage Students</h1>

<!-- Display the list of students -->
<?php if ($students) : ?>
    <table>
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($students as $student) : ?>
            <tr>
                <td><?php echo $student['student_id']; ?></td>
                <td><?php echo $student['student_name']; ?></td>
                <td>
                    <a class="btn btn-update" href="studentUpdate.php?id=<?php echo $student['student_id']; ?>">Update</a>
                    <a class="btn btn-delete" href="studentDelete.php?id=<?php echo $student['student_id']; ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>No students found.</p>
<?php endif; ?>


<br>


<a href="studentAdd.php"><button>Add Student</button></a>

<br>
<br>
<br>


<a href="adminDashboard.php"><button> to Admin Dashboard</button></a>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
