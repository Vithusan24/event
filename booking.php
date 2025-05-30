
<style>

/* Root variables for colors */
:root {
    --primary: #6a11cb;
    --secondary: #2575fc;
    --accent: #ff6b6b;
    --bg-light: #f9f9f9;
    --text: #333;
}

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
    background: linear-gradient(to right, var(--primary), var(--secondary));
    color: white;
    padding: 1rem;
    text-align: center;
}

header nav a {
    color: white;
    text-decoration: none;
    margin: 0 15px;
    font-weight: bold;
}

main {
    max-width: 800px;
    margin: 2rem auto;
    padding: 1rem;
}

h1, h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

h2 {
    color: var(--primary);
}

.colorful-section {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

form input,
form select,
form button {
    padding: 12px;
    font-size: 1rem;
    border-radius: 6px;
    border: 1px solid #ccc;
}

form input[type="text"],
form input[type="tel"],
form input[type="date"],
form select {
    width: 100%;
}

form button {
    background-color: var(--primary);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: var(--secondary);
}

.booking-confirmation p {
    margin: 10px 0;
}

.booking-details p {
    font-size: 1.1rem;
}

.booking-details {
    background-color: #f1f1f1;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.colorful-footer {
    background: linear-gradient(to right, #343a40, #000);
    color: white;
    text-align: center;
    padding: 1.5rem 0;
}

footer p {
    margin: 0;
}


</style>

<?php
session_start();

// Database connection
try {
    $conn = new PDO("mysql:host=localhost;dbname=vithu_mahal", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $event_date = $_POST['event_date'];
    $event_type = $_POST['event_type'];

    // Check for booking conflict
    $stmt = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE event_date = :event_date AND status != 'Rejected'");
    $stmt->bindParam(':event_date', $event_date);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $_SESSION['booking_message'] = "Sorry, the selected date is already booked. Please choose another date.";
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (name, phone, event_date, event_type, status) VALUES (:name, :phone, :event_date, :event_type, 'Pending')");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':event_date', $event_date);
        $stmt->bindParam(':event_type', $event_type);
        $stmt->execute();
        
        $booking_id = $conn->lastInsertId();
        $_SESSION['booking_message'] = "Booking #$booking_id submitted successfully!";
        $_SESSION['booking_details'] = [
            'id' => $booking_id,
            'name' => $name,
            'phone' => $phone,
            'event_date' => $event_date,
            'event_type' => $event_type
        ];
    }
    header("Location: booking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Event - Vithu Mahal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="colorful-header">
        <h1>Vithu Mahal Event Hall</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="about.php">About</a>
            <a href="booking.php">Book Now</a>
            <a href="contact.php">Contact</a>
            <a href="admin.php">Admin Login</a>
        </nav>
    </header>

    <main>
        <section class="booking-form colorful-section">
            <h2>Book Your Event</h2>
            <form action="booking.php" method="POST" onsubmit="return validateForm()">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>
                
                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" name="event_date" required>
                
                <label for="event_type">Event Type:</label>
                <select id="event_type" name="event_type" required>
                    <option value="Wedding">Wedding</option>
                    <option value="Party">Party</option>
                    <option value="Conference">Conference</option>
                    <option value="Other">Other</option>
                </select>
                
                <button type="submit" class="colorful-button">Submit Booking</button>
            </form>
        </section>

        <section class="booking-confirmation colorful-section">
            <h2>Booking Confirmation</h2>
            <?php
            if (isset($_SESSION['booking_message'])) {
                echo "<p>" . $_SESSION['booking_message'] . "</p>";
                
                if (isset($_SESSION['booking_details'])) {
                    $details = $_SESSION['booking_details'];
                    echo "<div class='booking-details'>";
                    echo "<p>Booking ID: " . $details['id'] . "</p>";
                    echo "<p>Name: " . $details['name'] . "</p>";
                    echo "<p>Phone: " . $details['phone'] . "</p>";
                    echo "<p>Event Date: " . $details['event_date'] . "</p>";
                    echo "<p>Event Type: " . $details['event_type'] . "</p>";
                    echo "</div>";
                    unset($_SESSION['booking_details']);
                }
                unset($_SESSION['booking_message']);
            } else {
                echo "<p>Please submit a booking using the form above.</p>";
            }
            ?>
        </section>
    </main>

    <footer class="colorful-footer">
        <p>© 2025 Vithu Mahal Event Hall. All rights reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
