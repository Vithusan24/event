<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About - Vithu Mahal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <style>
    :root {
      --primary-color: #6a11cb;
      --secondary-color: #2575fc;
      --accent-color: #ff6b6b;
      --text-color: #333;
      --light-color: #f8f9fa;
      --dark-color: #343a40;
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
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(8px);
      z-index: -1;
    }

    /* Header */
    .colorful-header {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 1rem 0;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .colorful-header h1 {
      margin: 0;
      font-size: 2.5rem;
    }

    nav {
      margin-top: 0.8rem;
    }

    .nav-link {
      color: white;
      text-decoration: none;
      font-weight: 500;
      margin: 0 1rem;
      padding: 0.4rem 0.8rem;
      border-radius: 4px;
      transition: all 0.3s ease;
      position: relative;
    }

    .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px);
    }

    .nav-link.active {
      background-color: rgba(255, 255, 255, 0.3);
    }

    /* Main Content */
    main {
      max-width: 1100px;
      margin: 2rem auto;
      padding: 0 1.5rem;
    }

    main section {
      margin-bottom: 3rem;
    }

    .colorful-section {
      background: #fff;
      border-radius: 8px;
      padding: 2rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .colorful-section:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    h2 {
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 1.5rem;
      position: relative;
    }

    h2::after {
      content: '';
      width: 80px;
      height: 4px;
      background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 2px;
    }

    .about-content {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      align-items: flex-start;
    }

    .about-text {
      flex: 1;
      min-width: 280px;
    }

    .features-list {
      list-style: none;
      padding-left: 0;
    }

    .features-list li {
      margin-bottom: 1rem;
      padding-left: 2rem;
      position: relative;
    }

    .features-list li i {
      color: var(--accent-color);
      position: absolute;
      left: 0;
      top: 3px;
    }

    .gallery-images {
      flex: 1;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1rem;
    }

    .gallery-photo {
      width: 100%;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .gallery-photo:hover {
      transform: scale(1.03);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Ads Section */
    .ads-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      padding: 20px 0;
    }

    .ad-block {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

        .colorful-footer {
            background: linear-gradient(to right, #343a40, #000);
            color: white;
            text-align: center;
            padding: 1.5rem 0;
        }
    .ad-block img.gallery-photo {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 6px;
      margin-bottom: 10px;
    }

    .ad-block h3 {
      font-size: 1.1rem;
      margin: 10px 0 5px;
    }

    .ad-block p {
      font-size: 0.95rem;
      color: #444;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .nav-link {
        display: block;
        margin: 0.5rem 0;
      }

      .about-content {
        flex-direction: column;
      }

      .gallery-images {
        grid-template-columns: 1fr;
      }

      .colorful-header h1 {
        font-size: 2rem;
      }

      .ads-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 480px) {
      .ads-grid {
        grid-template-columns: 1fr;
      }


      
    }
  </style>
</head>

<body>
  <header class="colorful-header">
    <h1>Vithu Mahal Event Hall</h1>
    <nav>
      <a href="index.html" class="nav-link">Home</a>
      <a href="about.html" class="nav-link active">About</a>
      <a href="booking.php" class="nav-link">Book Now</a>
      <a href="contact.php" class="nav-link">Contact</a>
      <a href="admin.php" class="nav-link">Admin Login</a>
    </nav>
  </header>

  <main>
    <!-- Section 1 -->
    <section class="about colorful-section">
      <h2>About Vithu Mahal</h2>
      <div class="about-content">
        <div class="about-text">
          <p>Vithu Mahal Event Hall is a premier venue for hosting unforgettable events. Our state-of-the-art facilities include:</p>
          <ul class="features-list">
            <li><i class="fas fa-users"></i> Spacious halls accommodating 50–500 guests</li>
            <li><i class="fas fa-tv"></i> Modern audio-visual equipment</li>
            <li><i class="fas fa-utensils"></i> Professional catering services</li>
            <li><i class="fas fa-user-tie"></i> Dedicated event planning staff</li>
          </ul>
        </div>
        <div class="gallery-images">
          <img src="images/hall1.webp" alt="Spacious Hall View" class="gallery-photo">
        </div>
      </div>
    </section>

    <!-- Section 2 -->
    <section class="about colorful-section">
      <h2>Why Choose Us</h2>
      <div class="about-content">
        <div class="about-text">
          <img src="images/hall2.webp" alt="Elegant Setup" class="gallery-photo">
        </div>
        <div class="gallery-images">
          <p>Vithu Mahal offers a perfect blend of elegance and comfort, suitable for various events such as weddings, conferences, and parties.</p>
          <ul class="features-list">
            <li><i class="fas fa-cocktail"></i> Elegant decoration themes customizable to your taste</li>
            <li><i class="fas fa-wifi"></i> High-speed Wi-Fi throughout the venue</li>
            <li><i class="fas fa-parking"></i> Ample parking space for guests</li>
            <li><i class="fas fa-clock"></i> Flexible event scheduling with 24/7 availability</li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Ads Section -->
    <section class="colorful-section">
      <h2>Latest Promotions</h2>
      <div class="ads-container">
        <?php
        try {
          $conn = new PDO("mysql:host=localhost;dbname=vithu_mahal", "root", "");
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->query("SELECT * FROM event_ads ORDER BY id DESC");
          echo '<div class="ads-grid">';
          while ($ad = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo '<div class="ad-block">';
              echo '<img src="images/' . htmlspecialchars($ad['image']) . '" alt="' . htmlspecialchars($ad['title']) . '" class="gallery-photo">';
              echo '<h3>' . htmlspecialchars($ad['title']) . '</h3>';
              echo '<p>' . nl2br(htmlspecialchars($ad['description'])) . '</p>';
              echo '</div>';
          }
          echo '</div>';
        } catch (PDOException $e) {
          echo "<p>Error loading advertisements.</p>";
        }
        ?>
      </div>
    </section>
  </main>


    <footer class="colorful-footer">
        <p>© 2025 Vithu Mahal Event Hall. All rights reserved.</p>
    </footer>
</body>
</html>
