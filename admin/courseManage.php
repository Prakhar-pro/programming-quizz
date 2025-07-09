<?php
session_start();

if(!isset($_SESSION["admin_id"])){
    header("Location: ../login.php");
    exit();
}
include "../DB_Functions.php";

//connect to db
$conn = connectServer('localhost', 'root', '', 0);
selectDB($conn, "Quizzify", 0);

//get all courses
$query = "SELECT courses.course_id, courses.course_name, teachers.teacher_name, teachers.teacher_id
FROM courses
JOIN teachers ON courses.teacher_id = teachers.teacher_id";

$result = mysqli_query($conn, $query);


if ($result) {
    //getting all courses
    $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
}
else{
    echo "error executing query";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

    <?php if($courses) : ?>
        <table>
                <tr>
                    <th>Course Id</th>
                    <th>Course Name</th>
                    <th>Teacher Name</th>
                    <th>Teacher Id</th>
                    <th>Actions</th>
                </tr>
                <?php foreach($courses as $course): ?>
                    
                    <tr>
                        <td><?php echo $course["course_id"]?></td>
                        <td><?php echo $course["course_name"]?></td>
                        <td><?php echo $course["teacher_name"]?></td>
                        <td><?php echo $course["teacher_id"]?></td>
                        <td>
                            <a class="btn btn-update" href="courseUpdate.php?id=<?php echo $course['course_id']; ?>">Update</a>
                            <a class="btn btn-delete" href="courseDelete.php?id=<?php echo $course['course_id']; ?>" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach;?>



        </table>
    <?php else : ?>
        <p>No Courses found.</p>
    <?php endif; ?>

    <br>


<a href="courseAdd.php"><button>Add Course</button></a>

<br>
<br>
<br>


<a href="adminDashboard.php"><button> to Admin Dashboard</button></a>

        
    
</body>
</html>
