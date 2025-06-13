document.addEventListener('DOMContentLoaded', function() {
    // Theme switcher (for future dark mode)
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark-theme');
            const currentTheme = document.documentElement.classList.contains('dark-theme') ? 'dark' : 'light';
            localStorage.setItem('theme', currentTheme);
            document.querySelectorAll('.theme-icon').forEach(icon => {
                icon.classList.toggle('hidden');
            });
            
        });
    }
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('active');
        });
    }

    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        const fileNameDisplay = document.createElement('span');
        fileNameDisplay.className = 'file-name-display';
        fileInput.insertAdjacentElement('afterend', fileNameDisplay);
        
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
            } else {
                fileNameDisplay.textContent = '';
            }
        });
    }

 
   // File search functionality
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('.file-list tr').forEach(row => {
                const fileName = row.querySelector('td:first-child').textContent.toLowerCase();
                row.style.display = fileName.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // File selection for batch operations
    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.file-checkbox').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
});
