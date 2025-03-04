const dropdownButton = document.getElementById('dropdown-button');
const dropdownMenu = document.getElementById('dropdown-menu');

// Function to open dropdown
function openDropdown() {
    dropdownMenu.classList.remove('opacity-0', 'pointer-events-none');
    setTimeout(() => {
        dropdownMenu.classList.remove('scale-y-0');
    }, 10);
}

// Function to close dropdown
function closeDropdown() {
    dropdownMenu.classList.add('scale-y-0');
    setTimeout(() => {
        dropdownMenu.classList.add('opacity-0', 'pointer-events-none');
    }, 200);
}

// Toggle dropdown on button click
dropdownButton.addEventListener('click', (event) => {
    event.stopPropagation(); // Prevent click from propagating to document

    if (dropdownMenu.classList.contains('scale-y-0')) {
        openDropdown();
    } else {
        closeDropdown();
    }
});

// Close dropdown when clicking outside
document.addEventListener('click', (event) => {
    if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
        closeDropdown();
    }
});