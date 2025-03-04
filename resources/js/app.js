import './bootstrap';
import.meta.glob([
    '../images/**'
]);

const dropdownButton = document.getElementById('dropdown-button');
const dropdownMenu = document.getElementById('dropdown-menu');
const mobileMenuButton = document.getElementById('mobileMenuButton');
const mobileMenu = document.getElementById('mobileMenuContainer');

// Function to open dropdown
function openDropdown(item) {
    item.classList.remove('opacity-0', 'pointer-events-none');
    setTimeout(() => {
        item.classList.remove('scale-y-0');
    }, 10);
}

// Function to close dropdown
function closeDropdown(item) {
    item.classList.add('scale-y-0');
    setTimeout(() => {
        item.classList.add('opacity-0', 'pointer-events-none');
    }, 200);
}

// Toggle dropdown on button click
dropdownButton.addEventListener('click', (event) => {
    event.stopPropagation(); // Prevent click from propagating to document

    if (dropdownMenu.classList.contains('scale-y-0')) {
        openDropdown(dropdownMenu);
    } else {
        closeDropdown(dropdownMenu);
    }
});


// Toggle menu on button click
mobileMenuButton.addEventListener('click', (event) => {
    event.stopPropagation(); // Prevent click from propagating to document

    if (mobileMenu.classList.contains('scale-y-0')) {
        openDropdown(mobileMenu);
    } else {
        closeDropdown(mobileMenu);
    }
});

// Close dropdown when clicking outside
document.addEventListener('click', (event) => {
    if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
        closeDropdown(dropdownMenu);
    }
});
// Close menu when clicking outside
document.addEventListener('click', (event) => {
    if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
        closeDropdown(mobileMenu);
    }
});