<?php
/*
Template Name: Custom Layout Template
Description: A reusable layout for new pages.
*/

get_header(); // Include the header
?>

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
    <section>
        <h1><?php the_title(); ?></h1>
        <div>
            <?php
            // Display the page content
            while (have_posts()) : the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </section>
</main>

<?php
get_footer(); // Include the footer
?>
