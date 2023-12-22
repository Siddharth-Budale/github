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
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
}

// Assuming you have a table named 'attendance'
$tableName = 'attendance';

// Fetch data from the database
$query = "SELECT * FROM $tableName WHERE sid = '$student_id' and cid='$subject'" ;
$query1 = "SELECT COUNT(*) as presentCount FROM $tableName WHERE sid = '$student_id' AND status='present'and cid='$subject'";
$query2 = "SELECT COUNT(*) as totalCount FROM $tableName WHERE sid = '$student_id'and cid='$subject'";

$result = mysqli_query($conn, $query);
$result1 = mysqli_query($conn, $query1);
$result2 = mysqli_query($conn, $query2);

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

        .student-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
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

    <div class="student-header">
        Student ID: <?php echo $student_id; ?>
    </div>

    <table>
        <tr>
            <th>Date</th>
            <th>Status</th>
        </tr>

        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2' class='error-message'>No data found in the table.</td></tr>";
        }
        ?>
    </table>

    <br>

    <table>
        <tr>
            <th>Present Count</th>
            <th>Total Count</th>
            <th>Attendance Percentage</th>
        </tr>

        <?php
        $row1 = mysqli_fetch_assoc($result1);
        $row2 = mysqli_fetch_assoc($result2);

        echo "<tr><td>";
        if ($row1 && isset($row1['presentCount'])) {
            echo $row1['presentCount'];
        } else {
            echo "<span class='error-message'>No present data found for the student.</span>";
        }
        echo "</td>";

        echo "<td>";
        if ($row2 && isset($row2['totalCount'])) {
            echo $row2['totalCount'];
        } else {
            echo "<span class='error-message'>No total data found for the student.</span>";
        }
        echo "</td>";

        echo "<td>";
        if ($row1 && isset($row1['presentCount']) && $row2 && isset($row2['totalCount'])) {
            if ($row2['totalCount'] == 0) {
                echo "No data";
            } else {
                $percentage = ($row1['presentCount'] / $row2['totalCount']) * 100;
                echo round($percentage, 2) . "%";
            }
        } else {
            echo "<span class='error-message'>No present data found for the student.</span>";
        }
        echo "</td></tr>";
        ?>
    </table>

    <button class="logout-button" onclick="location.href='student_summary.html'">Back</button>

    <?php
    // Free the result sets
    mysqli_free_result($result);
    mysqli_free_result($result1);
    mysqli_free_result($result2);

    mysqli_close($conn);
    ?>
</body>
</html>



