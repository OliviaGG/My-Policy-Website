<?php get_template_part('header'); ?>
<?php get_template_part('nav'); ?>
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

<?php get_template_part('footer'); ?>
