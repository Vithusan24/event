<?php
session_start();

// Database connection
try {
    $conn = new PDO("mysql:host=localhost;dbname=vithu_mahal", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Admin login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];

    if ($admin_username === "admin" && $admin_password === "admin123") {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $login_error = "Invalid credentials";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Admin actions
if (isset($_SESSION['admin_logged_in'])) {
    if (isset($_POST['approve'])) {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Approved' WHERE id = :id");
        $stmt->bindParam(':id', $_POST['booking_id']);
        $stmt->execute();
    }

    if (isset($_POST['reject'])) {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Rejected' WHERE id = :id");
        $stmt->bindParam(':id', $_POST['booking_id']);
        $stmt->execute();
    }

    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = :id");
        $stmt->bindParam(':id', $_POST['booking_id']);
        $stmt->execute();
    }

    if (isset($_POST['add_event_type'])) {
        $stmt = $conn->prepare("INSERT INTO event_types (name) VALUES (:name)");
        $stmt->bindParam(':name', $_POST['new_event_type']);
        $stmt->execute();
    }
}
if (isset($_POST['add_advertisement'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $image_name = $_FILES['image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image_name);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $stmt = $conn->prepare("INSERT INTO event_ads (title, description, image) VALUES (:title, :description, :image)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image_name);
    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Vithu Mahal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
       body {
  margin: 0;
  min-height: 100vh;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: var(--text-color);
  background: url('images/bg.jpg') no-repeat center center fixed;
  background-size: cover;
  position: relative;
  overflow-x: hidden;
}

body::before {
  content: '';
  position: fixed;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.6); /* White transparent layer */
  backdrop-filter: blur(8px);
  z-index: -1;
}

        header {
            background: linear-gradient(45deg, #4a148c, #880e4f);
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav a {
            margin: 0 10px;
            color: #ffcdd2;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 30px;
        }
        h2, h3 {
            color: #4a148c;
        }
        form {
            margin-top: 10px;
        }
        label {
            display: block;
            margin-top: 8px;
        }
        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .colorful-button {
            background: #4a148c;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .colorful-button:hover {
            background: #6a1b9a;
        }
        .colorful-section {
            background: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background:rgba(245, 245, 245, 0.86);
        }
        .actions form {
            display: inline-block;
        }
        .error {
            color: red;
        }
        footer {
            background: #4a148c;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<header>
    <h1>Vithu Mahal Event Hall - Admin</h1>
    <nav>
        <a href="index.html">Home</a>
        <a href="about.php">About</a>
        <a href="booking.php">Book Now</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<main>
    <?php if (!isset($_SESSION['admin_logged_in'])): ?>
        <div class="colorful-section">
            <h2>Admin Login</h2>
            <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
            <form method="POST">
                <label>Username:</label>
                <input type="text" name="username" required>
                <label>Password:</label>
                <input type="password" name="password" required>
                <button type="submit" name="login" class="colorful-button">Login</button>
            </form>
        </div>
    <?php else: ?>
        <div class="colorful-section">
            <h2>Dashboard</h2>
            <a href="admin.php?logout=1" class="colorful-button">Logout</a>
        </div>

        <div class="colorful-section">
            <h3>Booking Requests</h3>
            <form method="GET">
                <label>Filter by Status:</label>
                <select name="status" onchange="this.form.submit()">
                <option value="Pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
<option value="Approved" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
<option value="Rejected" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
</select>
            </form>
            <table>
                <tr>
                    <th>ID</th><th>Name</th><th>Phone</th><th>Event Date</th><th>Event Type</th><th>Status</th><th>Actions</th>
                </tr>
                <?php
                $query = "SELECT * FROM bookings";
                if (!empty($_GET['status'])) {
                    $query .= " WHERE status = :status";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':status', $_GET['status']);
                } else {
                    $stmt = $conn->prepare($query);
                }
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['event_date']}</td>
                        <td>{$row['event_type']}</td>
                        <td>{$row['status']}</td>
                        <td class='actions'>
                            <form method='POST'>
                                <input type='hidden' name='booking_id' value='{$row['id']}'>";
                    if ($row['status'] !== 'Approved') {
                        echo "<button name='approve' class='colorful-button'>Approve</button>";
                    }
                    if ($row['status'] !== 'Rejected') {
                        echo "<button name='reject' class='colorful-button'>Reject</button>";
                    }
                    echo "<button name='delete' class='colorful-button'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <div class="colorful-section">
            <h3>Inquiries</h3>
            <table>
                <tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th></tr>
                <?php
                $stmt = $conn->query("SELECT * FROM inquiries ORDER BY id DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>" . substr($row['message'], 0, 50) . "...</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <div class="colorful-section">
            <h3>Add New Event Type</h3>
            <form method="POST">
                <label>New Event Type:</label>
                <input type="text" name="new_event_type" required>
                <button type="submit" name="add_event_type" class="colorful-button">Add</button>
            </form>
        </div>



        <div class="colorful-section">
    <h3>Add Event Advertisement</h3>
    <form action="admin.php" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <label for="image">Upload Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit" name="add_advertisement" class="colorful-button">Add Advertisement</button>
    </form>
</div>
    <?php endif; ?>

</main>

<footer>
    <p>© 2025 Vithu Mahal Event Hall. All rights reserved.</p>
</footer>
</body>
</html>
