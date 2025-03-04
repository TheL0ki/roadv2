const mobileMenuButton = document.getElementById('mobileMenuButton');
const mobileMenu = document.getElementById('mobileMenuContainer');

// Function to open dropdown
function openMobileMenu() {
    mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
    setTimeout(() => {
        mobileMenu.classList.remove('scale-y-0');
    }, 10);
}

// Function to close dropdown
function closeMobileMenu() {
    mobileMenu.classList.add('scale-y-0');
    setTimeout(() => {
        mobileMenu.classList.add('opacity-0', 'pointer-events-none');
    }, 200);
}

// Toggle dropdown on button click
mobileMenuButton.addEventListener('click', (event) => {
    event.stopPropagation(); // Prevent click from propagating to document

    if (mobileMenu.classList.contains('scale-y-0')) {
        openMobileMenu();
    } else {
        closeMobileMenu();
    }
});

// Close dropdown when clicking outside
document.addEventListener('click', (event) => {
    if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
        closeMobileMenu();
    }
});