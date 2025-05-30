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
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO inquiries (name, email, message) VALUES (:name, :email, :message)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    $_SESSION['inquiry_message'] = "Thank you for your inquiry! We'll contact you soon.";
    header("Location: contact.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Vithu Mahal</title>
    <style>
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
  backdrop-filter: blur(8px);
  z-index: -1;
}

        .colorful-header {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 1rem;
            text-align: center;
        }

        nav a {
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

        .colorful-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .contact-info p {
            margin: 0.5rem 0;
        }

        .contact-form form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .colorful-button {
            background: var(--primary);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
            align-self: center;
        }

        .colorful-button:hover {
            background: var(--secondary);
        }

        .inquiry-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 1rem;
            border-radius: 6px;
            margin-top: 1rem;
            text-align: center;
        }

        .colorful-footer {
            background: linear-gradient(to right, #343a40, #000);
            color: white;
            text-align: center;
            padding: 1.5rem 0;
        }
    </style>
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
        <section class="contact colorful-section">
            <h2>Contact Us</h2>
            <div class="contact-info">
                <p><strong>Email:</strong> info@vithumahal.com</p>
                <p><strong>Phone:</strong> +94 (076) 787-5639</p>
                <p><strong>Address:</strong> 89 Event Street, jaffna, srilanka</p>
            </div>

            <div class="contact-form colorful-section">
                <h3>Send an Inquiry</h3>
                <form action="contact.php" method="POST" onsubmit="return validateInquiryForm()">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                    
                    <button type="submit" class="colorful-button">Submit Inquiry</button>
                </form>
            </div>
<div class="colorful-section">
    <h3>Our Location</h3>
    <div style="width: 100%; height: 400px;">
        <iframe 
            src="https://www.google.com/maps?q=89+Event+Street,+Jaffna,+Sri+Lanka&output=embed"
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

            <?php
            if (isset($_SESSION['inquiry_message'])) {
                echo "<div class='inquiry-message'>";
                echo "<p>" . $_SESSION['inquiry_message'] . "</p>";
                echo "</div>";
                unset($_SESSION['inquiry_message']);
            }
            ?>
        </section>
    </main>

    <footer class="colorful-footer">
        <p>© 2025 Vithu Mahal Event Hall. All rights reserved.</p>
    </footer>

    <script>
        function validateInquiryForm() {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const message = document.getElementById("message").value.trim();
            if (!name || !email || !message) {
                alert("Please fill in all required fields.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
