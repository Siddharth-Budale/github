<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Include your database connection code here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #c0c0c0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #ff0000;
        }

        p {
            margin-bottom: 20px;
            color: #555;
        }

        h2 {
            color: #800080; /* Green color */
            margin-top: 30px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        a {
            display: block;
            padding: 10px;
            background-color: #000000; /* Green color */
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #45a049; /* Darker green color on hover */
        }

        a.logout {
            margin-top: 20px;
            color: #dc3545;
        }

        a.logout:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome</h1>


        <h2>Manage Users</h2>
        <ul>
        <ul>
        <ul>
        <li><a href="add_teacher.php" style="color: #800080; background-color: #faebd7; font-weight: bold;">Add Teacher</a></li>
        <li><a href="add_student.php" style="color: #ff0000; background-color: #00ff7f; font-weight: bold;">Add Student</a></li>
        <li><a href="delete_teacher.php" style="color: #800080; background-color: #faebd7; font-weight: bold;">Delete Teacher</a></li>
        <li><a href="delete_student.php" style="color: #ff0000; background-color: #00ff7f; font-weight: bold;">Delete Student</a></li>
        <li><a href="teacher_list.php" style="color: #800080; background-color: #faebd7; font-weight: bold;">Teacher List</a></li>
        <li><a href="student_summary.html" style="color: #ff0000; background-color: #00ff7f; font-weight: bold;">Student Summary</a></li>
        <li><a href="attendance_summary.html" style="color: #800080; background-color: #faebd7; font-weight: bold;">Attendance List</a></li>
        <li><a href="edit_attendance.php" style="color: #ff0000; background-color: #00ff7f; font-weight: bold;">Edit Attendance</a></li>

</ul>

</ul>

        </ul>

        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
