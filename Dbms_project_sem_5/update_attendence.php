<?php
// Start the session
session_start();

// Database connection
$host = 'localhost';
$username = 'root';
// $password = 'root';
$database = 'attendence_db';

$conn = mysqli_connect($host, $username, '', $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch courses associated with the logged-in teacher
$username = mysqli_real_escape_string($conn, $_SESSION['username']);
$sql = "SELECT cid FROM course WHERE fid IN (SELECT fid FROM faculty WHERE username = '$username')";
$result = mysqli_query($conn, $sql);

$data = array();

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    mysqli_free_result($result);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Page</title>
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

        h1, h2 {
            color: #007BFF;
            text-align: center;
        }

        p {
            text-align: center;
            color: #333;
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
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('arrow-down.png') no-repeat right center;
        }

        select::-ms-expand {
            display: none;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #333;
            text-decoration: none;
        }

        a:hover {
            color: #007BFF;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        
        <h2>Update Attendance</h2>
        <form action="update_attendence.php" method="post">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required>
            
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            
            <label for="status">Attendance Status:</label>
            <select id="status" name="status">
                <option value="present">Present</option>
                <option value="absent">Absent</option>
            </select>

            <label for="course">Select Course:</label>
            <select id="course" name="course">
                <?php
                    foreach ($data as $row) {
                        echo "<option value='{$row['cid']}'>{$row['cid']}</option>";
                    }
                ?>
            </select>

            <input type="submit" name="submit" id="submit" value="Submit">
        </form>

        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

<?php
// Database connection
$host = 'localhost';
$username = 'root';
// $password = 'root';
$database = 'attendence_db';

$conn = mysqli_connect($host, $username, '', $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $cid = mysqli_real_escape_string($conn, $_POST['course']);

    // Validate if the student exists
    $dup = "SELECT * FROM student WHERE sid='$student_id'";
    $result = mysqli_query($conn, $dup);

    if (!mysqli_num_rows($result) > 0) {
        echo "<p style='text-align: center; color: red; font-weight: bold;'>Student record doesn't exist</p>";
    } else {
        // Check if attendance record already exists
        $dup1 = "SELECT * FROM attendance WHERE sid='$student_id' and cid= '$cid' and date='$date'";
        $result1 = mysqli_query($conn, $dup1);

        if (mysqli_num_rows($result1) > 0) {
            echo "<p style='text-align: center; color: red; font-weight: bold;'>Attendance record exists</p>";
        } else {
            // Insert attendance record
            $sql = "INSERT INTO attendance (cid, sid, date, status) VALUES ('$cid', '$student_id', '$date', '$status')";

            if ($conn->query($sql) === TRUE) {
                echo "<p style='text-align: center; color: red; font-weight: bold;'>Record inserted successfully</p>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

mysqli_close($conn);
?>


