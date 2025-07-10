const header = document.querySelector('header');

// Change this value to control how far you scroll before the header hides
const HIDE_SCROLL_THRESHOLD = 120;

window.addEventListener('scroll', () => {
  if (window.scrollY > HIDE_SCROLL_THRESHOLD) {
    header.classList.add('header-hidden');
  } else {
    header.classList.remove('header-hidden');
  }
});