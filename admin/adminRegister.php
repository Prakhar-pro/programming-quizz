<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["admin_id"])) {
    // Redirect to the login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Include database connection and functions
include "../DB_Functions.php";

// Connect to the server
$conn = connectServer('localhost', 'root', '', 0);

// Select the database
selectDB($conn, "Quizzify", 0);

// Initialize variables
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $newAdminName = $_POST["new_admin_name"];
    $newAdminUsername = $_POST["new_admin_username"];
    $newAdminPassword = $_POST["new_admin_password"];

    // Validate input
    if (empty($newAdminName) || empty($newAdminUsername) || empty($newAdminPassword)) {
        $error_message = "All fields are required.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($newAdminPassword, PASSWORD_DEFAULT);

        // Insert the new admin into the database
        $query = "INSERT INTO admins (admin_name, username, password_hash) VALUES ('$newAdminName', '$newAdminUsername', '$hashedPassword')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Admin successfully added
            header("Location: adminDashboard.php");
            exit();
        } else {
            // Error adding admin
            $error_message = "Error adding new admin. Please try again.";
        }
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h2>Register New Admin</h2>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <label for="new_admin_name">Admin Name:</label>
    <input type="text" id="new_admin_name" name="new_admin_name" required>

    <label for="new_admin_username">Username:</label>
    <input type="text" id="new_admin_username" name="new_admin_username" required>

    <label for="new_admin_password">Password:</label>
    <input type="password" id="new_admin_password" name="new_admin_password" required>

    <button type="submit">Register</button>
</form>

<?php
if (!empty($error_message)) {
    echo "<p style='color: red;'>$error_message</p>";
}
?>

<br>
<br>
<br>


<a href="adminDashboard.php"><button> to Admin Dashboard</button></a>

</body>
</html>
