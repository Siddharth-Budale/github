<?php

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
    $sem = mysqli_real_escape_string($conn, $_POST['sem']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
}

// Fetch data from the database
$query = "SELECT sid, COUNT(CASE WHEN status='present' THEN 1 END) AS present, COUNT(*) AS total FROM attendance WHERE sid IN (SELECT sid FROM student WHERE sem = '$sem') AND cid='$subject' GROUP BY sid";

$result = mysqli_query($conn, $query);
$course_id = array("mat_100" => "Math"  ,"sst_100" => "Social"  ,"sc_100" => "Science"  ,"eng_100" => "English"  , "art_100" => "Art");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Summary</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .course-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .result-message {
            font-weight: bold;
            color: #007BFF;
        }

        .error-message {
            font-weight: bold;
            color: #dc3545;
        }

        .logout-button {
            display: block;
            padding: 10px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            margin-top: 20px;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="course-header">
        Course ID: <?php echo $subject; ?><br>
        Course Name: <?php echo $course_id[$subject]; ?><br>
        Sem: <?php echo $sem; ?><br>
    </div>


    <table>
        <tr>
            <th>Student ID</th>
            <th>Classes Attended</th>
            <th>Total Classes</th>
            <th>Percentage</th>
        </tr>

        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['sid'] . "</td>";
                echo "<td>" . $row['present'] . "</td>";
                echo "<td>" . $row['total'] . "</td>";
                echo "<td>" . round(($row['present'] / $row['total']) * 100, 2) . "%</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='error-message'>No data found in the table.</td></tr>";
        }
        ?>
    </table>

    <button class="logout-button" onclick="location.href='attendance_summary.html'">Back</button>

    <?php
    // Free the result set
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</body>
</html>
