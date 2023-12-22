<?php
// Include your database connection code here
$host = 'localhost';
$username = 'root';
// $password = 'root';
$database = 'attendence_db'; // Corrected database name

$conn = mysqli_connect($host, $username, '', $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$teacher_id = ""; // Set a default value
$password = "";   // Set a default value

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $teacher_name = mysqli_real_escape_string($conn, $_POST['teacher_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $subject_array = isset($_POST['checkboxGroup']) ? $_POST['checkboxGroup'] : [];
    
    // Validation for teacher id and username
    $query = "SELECT * FROM faculty WHERE fid='$teacher_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<p style='text-align: center; color: red; font-weight: bold;'>Teacher record exists</p>";
        // header("Location: add_teacher.html");
        // exit; // Stop further execution
    } else {
        // Insert into users table
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'teacher')";
        if ($conn->query($sql) === TRUE) {
            // Insert into faculty table
            $sql = "INSERT INTO faculty (fid, fname, username) VALUES ('$teacher_id', '$teacher_name', '$username')";
            if ($conn->query($sql) === TRUE) {
                // Insert into course table for each selected subject
                $course_id = array("math" => "mat_100", "social" => "sst_100", "science" => "sc_100", "english" => "eng_100", "art" => "art_100");
                foreach ($subject_array as $subject) {
                    $sql = "INSERT INTO course (cid, cname, fid) VALUES ('" . $course_id[$subject] . "', '$subject', '$teacher_id')";
                    if ($conn->query($sql) !== TRUE) {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
                echo "<p style='text-align: center; color: red; font-weight: bold;'>Teacher record added</p>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
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
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .subject-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .subject-checkbox input {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: #007BFF;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
        <h1>Add Teacher</h1>
        <form action="add_teacher.php" method="post">
            <div class="form-group">
                <label for="teacher_id">Teacher ID:</label>
                <input type="text" id="teacher_id" name="teacher_id" required>
            </div>

            <div class="form-group">
                <label for="teacher_name">Teacher Name:</label>
                <input type="text" id="teacher_name" name="teacher_name" required>
            </div>

            <div class="form-group">
                <label>Subjects:</label>
                <div class="subject-checkbox">
                    <input type="checkbox" id="math" name="checkboxGroup[]" value="math">
                    <label for="math">Math</label>
                </div>

                <div class="subject-checkbox">
                    <input type="checkbox" id="social" name="checkboxGroup[]" value="social">
                    <label for="social">Social</label>
                </div>

                <div class="subject-checkbox">
                    <input type="checkbox" id="science" name="checkboxGroup[]" value="science">
                    <label for="science">Science</label>
                </div>

                <div class="subject-checkbox">
                    <input type="checkbox" id="english" name="checkboxGroup[]" value="english">
                    <label for="english">English</label>
                </div>

                <div class="subject-checkbox">
                    <input type="checkbox" id="art" name="checkboxGroup[]" value="art">
                    <label for="art">Art</label>
                </div>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Add Teacher" class="btn btn-primary">
                <button type="button" class="btn btn-secondary"><a href="admin.php">Back</a></button>
            </div>
        </form>
    </div>
</body>
</html>
