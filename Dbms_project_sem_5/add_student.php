<?php

function connectToDatabase() {
    $host = 'localhost';
    $username = 'root';
    $database = 'attendence_db';

    $conn = mysqli_connect($host, $username, '', $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

function addStudent($conn, $student_id, $name, $sem) {
    $sql = "INSERT INTO student (sid, sname, sem) VALUES ('$student_id', '$name', '$sem')";
    return $conn->query($sql);
}

function doesStudentExist($conn, $student_id) {
    $dupQuery = "SELECT * FROM student WHERE sid='$student_id'";
    $result = mysqli_query($conn, $dupQuery);

    return mysqli_num_rows($result) > 0;
}

function enrollStudentInCourses($conn, $student_id, $courses) {
    foreach ($courses as $subject) {
        $query = "INSERT INTO enrolled_course (cid, sid) VALUES ('$subject', '$student_id')";
        if (!$conn->query($query)) {
            return false;
        }
    }

    return true;
}
//here i am 
function all_courses_present($conn) {
    $sql = "select distinct(cid) from course";
    $result= $conn->query($sql);
    return mysqli_num_rows($result) > 4;
}
$showAlert = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectToDatabase();
    
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $sem = mysqli_real_escape_string($conn, $_POST['sem']);

    if(all_courses_present($conn)){
        if (doesStudentExist($conn, $student_id)) {
            echo "<p style='text-align: center; color: red; font-weight: bold;'>Student record exists</p>";
        } else {
            if (addStudent($conn, $student_id, $name, $sem) && enrollStudentInCourses($conn, $student_id, ["mat_100", "sst_100", "sc_100", "eng_100", "art_100"])) {
                echo "<p style='text-align: center; color: red; font-weight: bold;'>Student record successfully added</p>";
                $showAlert = true;
            }
        }
    }
    else {
        echo "<p style='text-align: center; color: red; font-weight: bold;'>Courses not available</p>";
    }
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007BFF;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-top: 20px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Student</h1>
        <form action="add_student.php" method="post">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required>

            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required>

            <label for="sem">Sem:</label>
            <input type="number" id="sem" name="sem" required>

            <input type="submit" value="Add Student">

            <div class="form-group">
                <button type="button" class="btn btn-secondary"><a href="admin.php">Back</a></button>
            </div>
        </form>
    </div>
</body>
</html>
