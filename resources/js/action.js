document.addEventListener("DOMContentLoaded", function () {
    // Get elements
    const checkboxes = document.querySelectorAll('.rowCheckbox');
    const checkAll = document.getElementById('checkAll');
    const actionDropdown = document.getElementById('actionDropdown');
    const dropdownToggle = document.getElementById('dropdownToggle');
    const dropdownMenu = document.getElementById('dropdownMenus');

    // Initialize the anyChecked variable to false (dropdown hidden by default)
    let anyChecked = false;

    // Function to update dropdown visibility based on checkbox state
    function updateDropdownVisibility() {
        if (actionDropdown) {
            actionDropdown.hidden = !anyChecked;
        }
    }

    // Function to update row highlighting when checkbox state changes
    function updateRowHighlight(cb) {
        const row = cb.closest('tr');
        if (cb.checked) {
            row.classList.add('bg-gray-100');
        } else {
            row.classList.remove('bg-gray-100');
        }
    }

    // Function to manually check if any checkbox is selected
    function checkAnySelected() {
        anyChecked = false;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                anyChecked = true;
            }
        });
        updateDropdownVisibility();
    }

    // Add event listeners to individual checkboxes
    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            updateRowHighlight(cb);
            checkAnySelected();
        });
    });

    // Add event listener to "Check All" checkbox
    if (checkAll) {
        checkAll.addEventListener('change', () => {
            checkboxes.forEach(cb => {
                cb.checked = checkAll.checked;
                updateRowHighlight(cb);
            });
            anyChecked = checkAll.checked;
            updateDropdownVisibility();
        });
    }

    // Toggle dropdown menu when button is clicked
    if (dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!dropdownMenu.contains(e.target) && !dropdownToggle.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    }

    // Initial state
    checkAnySelected();
});
window.data = data;
