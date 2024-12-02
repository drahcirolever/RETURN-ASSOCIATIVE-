<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    <style>
        /* General styles for the navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            padding: 10px 20px;
            color: white;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Style for the welcome message */
        nav .welcome-message {
            font-size: 18px;
            font-weight: bold;
        }

        /* Style for the navigation links */
        nav .nav-links {
            display: flex;
            gap: 15px;
        }

        nav .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for links */
        nav .nav-links a:hover {
            background-color: #34495e;
        }

        /* Active/Logout button styles */
        nav .nav-links a:last-child {
            background-color: #e74c3c;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
        }

        nav .nav-links a:last-child:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <nav>
        <div class="welcome-message">
            Hello there! Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="insert.php">Add New Applicant</a>
            <a href="allusers.php">All Users</a>
            <a href="activitylogs.php">Activity Logs</a>
            <a href="core/handleForms.php?logoutUserBtn=1">Logout</a>
        </div>
    </nav>
</body>
</html>