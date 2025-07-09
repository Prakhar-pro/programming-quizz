<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit();
}

// Include necessary functions and database connection
include "../DB_Functions.php";

$conn = connectServer('localhost', 'root', '', 0);
selectDB($conn, "Quizzify", 0);

// Fetch and display list of teachers
$teachers = getTeachersList($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h1>Manage Teachers</h1>

<!-- Display the list of teachers -->
<?php if ($teachers) : ?>
    <table>
        <tr>
            <th>Teacher ID</th>
            <th>Teacher Name</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($teachers as $teacher) : ?>
            <tr>
                <td><?php echo $teacher['teacher_id']; ?></td>
                <td><?php echo $teacher['teacher_name']; ?></td>
                <td><?php echo $teacher['username']; ?></td>
                <td>
                    <a class="btn btn-update" href="teacherUpdate.php?id=<?php echo $teacher['teacher_id']; ?>">Update</a>
                    <a class="btn btn-delete" href="teacherDelete.php?id=<?php echo $teacher['teacher_id']; ?>" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>No teachers found.</p>
<?php endif; ?>


<br>


<a href="teacherAdd.php"><button>Add Teacher</button></a>

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
