<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Our Nonprofit Political Org – Content Manager</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome (public CDN) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <!-- Your CSS -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <a href="#main-content" class="skip-link">Skip to main content</a>
  <header role="banner">
    <h1><i class="fas fa-hand-holding-heart" aria-hidden="true"></i> Our Nonprofit Political Org</h1>
    <p>Empowering voices. Advancing change.</p>
  </header>

  <!--Nav-->
 <nav aria-label="Main navigation">
  <ul class="main-nav">
    <li class="dropdown">
      <a href="#about" tabindex="0" aria-haspopup="true" aria-expanded="false">
        About <i class="fas fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu">
        <li><a href="#mission">Mission</a></li>
        <li><a href="Leadership Team/team.php">Our Team</a></li>
        <li><a href="#history">History</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#events" tabindex="0" aria-haspopup="true" aria-expanded="false">
        Events <i class="fas fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu">
        <li><a href="#upcoming">Upcoming Events</a></li>
        <li><a href="#past">Past Events</a></li>
        <li><a href="#workshops">Workshops</a></li>
      </ul>
    </li>
    <li><a href="#news" tabindex="0">News</a></li>
    <li><a href="#contact" tabindex="0">Contact</a></li>
    <li><a href="#donate" tabindex="0">Donate</a></li>
  </ul>
</nav>
  <!-- Accessibility Widget Button -->
  <button class="a11y-widget-btn" id="a11yWidgetBtn" aria-label="Accessibility options" aria-haspopup="dialog" aria-controls="a11yWidgetPanel">
    <i class="fas fa-universal-access"></i>
  </button>

  <!-- Accessibility Widget Panel -->
  <div id="a11yWidgetPanel" class="a11y-widget-panel" role="dialog" aria-modal="true" aria-label="Accessibility options">
    <strong style="font-size:1.1em;">Accessibility Options</strong>
    <label>
      <input type="checkbox" id="toggleDyslexic">
      Use OpenDyslexic Font
    </label>
    <label for="textSizeSlider" style="flex-direction: column; align-items: flex-start;">
      <span>Text Size: <span id="textSizeValue" style="font-weight:bold;">100%</span></span>
      <input type="range" id="textSizeSlider" min="80" max="200" value="100" step="5" style="width:100%;">
    </label>
    <label>
      <input type="checkbox" id="toggleHighContrast">
      High Contrast
    </label>
    <button type="button" id="resetA11y">Reset to Default</button>
  </div>

  <main id="main-content" tabindex="-1" role="main">
    <section id="about">
      <h2>Our Mission</h2>
      <p>We advocate for fair policies, civic engagement, and equal representation. Join us as we drive meaningful political change for our community.</p>
    </section>

    <div class="cta" id="donate">
      <p><strong>Support our work!</strong> <a href="#">Donate</a> or <a href="#">volunteer</a> today.</p>
    </div>

    <section id="events">
      <h2>Upcoming Events</h2>
      <ul>
        <li><strong>June 30:</strong> Community Town Hall (Online)</li>
        <li><strong>July 15:</strong> Policy Workshop (In-person)</li>
      </ul>
    </section>

    <section id="news">
      <h2>Latest News</h2>
      <ul>
        <li>We’ve launched our new voter education initiative!</li>
        <li>Local leaders join our advisory board.</li>
      </ul>
    </section>

    <section id="contact">
      <h2>Contact Us</h2>
      <form aria-label="Contact form">
        <label for="name">Name:</label><br>
        <input id="name" name="name" type="text" required aria-required="true"><br>
        <label for="email">Email:</label><br>
        <input id="email" name="email" type="email" required aria-required="true"><br>
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" required aria-required="true"></textarea><br>
        <button type="submit">Send</button>
      </form>
    </section>
  </main>

  <footer class="footer" role="contentinfo">
    <div class="social-icons" aria-label="Social media">
      <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
      <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
      <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
    </div>
    <div>
      <a href="#" style="color:#fff; text-decoration:underline;">Privacy Policy</a> | 
      <a href="#" style="color:#fff; text-decoration:underline;">Terms of Service</a>
    </div>
    <div>&copy; 2025 Our Nonprofit Political Org</div>
  </footer>

  <script src="accessibility-widget.js" defer></script> 
  <script src="hide-on-scroll.js" defer></script>

</body>
</html>
