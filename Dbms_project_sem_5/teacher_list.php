<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Teacher List</h1>

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

    // Fetch data from the database
    $query = "SELECT fid,  GROUP_CONCAT(cname) AS course_names, fname, username FROM course NATURAL JOIN faculty GROUP BY fid";
    $result = mysqli_query($conn, $query);
    ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Teacher ID</th>
                    <th>Course Names</th>
                    <th>Teacher Name</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                    <td style="color: blue;"><?php echo $row['fid']; ?></td>
                    <td style="color: green;"><?php echo $row['course_names']; ?></td>
                    <td style="color: red;"><?php echo $row['fname']; ?></td>
                    <td style="color: orange;"><?php echo $row['username']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No records found</p>
    <?php endif; ?>

    <?php mysqli_close($conn); ?>

    <button class="logout-button" style="color: #000000; background-color: #7cfc00;" onclick="location.href='admin.php'">Back</button>
</body>
</html>
