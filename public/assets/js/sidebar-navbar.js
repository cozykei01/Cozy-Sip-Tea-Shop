document.addEventListener('DOMContentLoaded', () => {
    const profileTrigger = document.getElementById('profileTrigger');
    const profileDropdown = document.getElementById('profileDropdown');

    // Toggle dropdown on click
    profileTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('show');
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', () => {
        if (profileDropdown.classList.contains('show')) {
            profileDropdown.classList.remove('show');
        }
    });
});