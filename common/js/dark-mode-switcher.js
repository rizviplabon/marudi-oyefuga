// Dark Mode Switcher

// Function to toggle dark mode
function toggleDarkMode() {
    const body = document.body;
    const darkModeLabel = document.querySelector('.dark-mode-label');
    
    // Toggle dark-mode class on body
    if (body.classList.contains('dark-skin')) {
        body.classList.remove('dark-skin');
        body.classList.add('light-skin');
        localStorage.setItem('darkMode', 'false');
        document.getElementById('darkModeIcon').classList.remove('fa-sun');
        document.getElementById('darkModeIcon').classList.add('fa-moon');
        if (darkModeLabel) darkModeLabel.textContent = 'Light';
    } else {
        body.classList.add('dark-skin');
        body.classList.remove('light-skin');
        localStorage.setItem('darkMode', 'true');
        document.getElementById('darkModeIcon').classList.remove('fa-moon');
        document.getElementById('darkModeIcon').classList.add('fa-sun');
        if (darkModeLabel) darkModeLabel.textContent = 'Dark';
    }
}

// Function to initialize dark mode based on user's preference
function initDarkMode() {
    const darkModeEnabled = localStorage.getItem('darkMode') === 'true';
    const body = document.body;
    const darkModeLabel = document.querySelector('.dark-mode-label');
    
    if (darkModeEnabled) {
        body.classList.add('dark-skin');
        body.classList.remove('light-skin');
        document.getElementById('darkModeIcon').classList.remove('fa-moon');
        document.getElementById('darkModeIcon').classList.add('fa-sun');
        if (darkModeLabel) darkModeLabel.textContent = 'Dark';
    } else {
        body.classList.remove('dark-skin');
        body.classList.add('light-skin');
        document.getElementById('darkModeIcon').classList.remove('fa-sun');
        document.getElementById('darkModeIcon').classList.add('fa-moon');
        if (darkModeLabel) darkModeLabel.textContent = 'Light';
    }
}

// Initialize dark mode when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit to ensure the DOM is fully loaded
    setTimeout(initDarkMode, 100);
});