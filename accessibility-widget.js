 // Accessibility Widget Script
const btn = document.getElementById('a11yWidgetBtn');
const panel = document.getElementById('a11yWidgetPanel');
const dyslexic = document.getElementById('toggleDyslexic');
const highContrast = document.getElementById('toggleHighContrast');
const resetBtn = document.getElementById('resetA11y');
const textSizeSlider = document.getElementById('textSizeSlider');
const textSizeValue = document.getElementById('textSizeValue');

// Open/Close widget
btn.addEventListener('click', () => {
  panel.classList.toggle('active');
  if(panel.classList.contains('active')) panel.focus();
});
document.addEventListener('mousedown', (e) => {
  if (panel.classList.contains('active') && !panel.contains(e.target) && e.target !== btn) {
    panel.classList.remove('active');
  }
});

// Restore preferences on load
window.addEventListener('DOMContentLoaded', () => {
  if(localStorage.a11yDyslexic === 'true') { 
    dyslexic.checked = true; 
    document.body.classList.add('a11y-dyslexic'); 
  }
  if(localStorage.a11yHighContrast === 'true') { 
    highContrast.checked = true; 
    document.body.classList.add('a11y-high-contrast'); 
  }
  let savedSize = localStorage.getItem('a11yTextSize');
  if (savedSize) {
    const scale = savedSize / 100;
    document.documentElement.style.setProperty('--ui-scale', scale);
    textSizeSlider.value = savedSize;
    textSizeValue.textContent = savedSize + '%';
  } else {
    document.documentElement.style.setProperty('--ui-scale', 1);
    textSizeSlider.value = 100;
    textSizeValue.textContent = '100%';
  }
});

// Feature toggles
function setFeature(className, input, storageKey) {
  if(input.checked) {
    document.body.classList.add(className);
    localStorage.setItem(storageKey, 'true');
  } else {
    document.body.classList.remove(className);
    localStorage.setItem(storageKey, 'false');
  }
}
dyslexic.addEventListener('change', () => setFeature('a11y-dyslexic', dyslexic, 'a11yDyslexic'));
highContrast.addEventListener('change', () => setFeature('a11y-high-contrast', highContrast, 'a11yHighContrast'));

// Text size/UI scale slider
textSizeSlider.addEventListener('input', function() {
  const scale = this.value / 100;
  document.documentElement.style.setProperty('--ui-scale', scale);
  textSizeValue.textContent = this.value + '%';
  localStorage.setItem('a11yTextSize', this.value);
});

// Reset everything
resetBtn.addEventListener('click', () => {
  dyslexic.checked = false;
  highContrast.checked = false;
  document.body.classList.remove('a11y-dyslexic', 'a11y-high-contrast');
  document.documentElement.style.setProperty('--ui-scale', 1);
  textSizeSlider.value = 100;
  textSizeValue.textContent = '100%';
  localStorage.removeItem('a11yDyslexic');
  localStorage.removeItem('a11yHighContrast');
  localStorage.removeItem('a11yTextSize');
});

// ESC closes widget
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && panel.classList.contains('active')) {
    panel.classList.remove('active');
    btn.focus();
  }
});