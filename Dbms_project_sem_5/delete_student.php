<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            margin-top: 10px;
            background-color: #6C757D;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-secondary a {
            color: #fff;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Student</h1>
        <form action="delete_student.php" method="post">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required>
            <input type="submit" value="Delete Student">
        </form>

        <div class="form-group">
            <button type="button" class="btn btn-secondary">
                <a href="admin.php">Back</a>
            </button>
        </div>
    </div>
</body>
</html>


<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Include your database connection code here
$host = 'localhost';
$username = 'root';
// $password = 'root';
$database = 'attendence_db';

$conn = mysqli_connect($host, $username, '', $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission and delete student
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    
    $delete_query = "DELETE FROM student WHERE sid  ='$student_id'";
    $result = mysqli_query($conn, $delete_query);

    if ($result) {
        // Check the number of affected rows
        $affected_rows = mysqli_affected_rows($conn);

        if ($affected_rows > 0) {
            echo "<p style='text-align: center; color: red; font-weight: bold;'>Student Seleted Succesfully</p>";
        } else {
            echo "<p style='text-align: center; color: red; font-weight: bold;'>No Student found with the provided ID</p>";
        }
    } else {
        echo "Error deleting student: " . mysqli_error($conn);
    }
}

// Include the necessary HTML, CSS, and PHP code for your header, navigation, and footer
?>


