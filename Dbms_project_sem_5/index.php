<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 400px;
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

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="password"],
        select {
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
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="index.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="admin">Admin</option>
                <option value="teacher">Teacher</option>
            </select>

            <input type="submit" value="Login">
        </form>
    </div>
</body>
    <?php
    // Database connection (replace with your database credentials)
    $host = 'localhost';
    $username = 'root';
    // $password = 'root';
    $database = 'attendence_db';

    $conn = mysqli_connect($host,$username,'',$database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Process login form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        // Validate user credentials
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            
            if ($role === 'admin') {
                header("Location: admin.php");
            } elseif ($role === 'teacher') {
                header("Location: update_attendence.php");
            }
            
        } else {
            //error_log("Invalid login credentials for username: $username, role: $role");
            echo "<p style='text-align: center; color: red; font-weight: bold;'>Invalid credintials </p>";
            

            
        }
        
        mysqli_close($conn);
    }
    ?>

</html>

