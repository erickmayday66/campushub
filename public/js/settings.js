  // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        
        // Check for saved theme preference or respect OS preference
        const savedTheme = localStorage.getItem('theme');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        
        if (savedTheme === 'dark' || (!savedTheme && prefersDarkScheme.matches)) {
            body.classList.add('dark-theme');
            themeToggle.checked = true;
        }
        
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            }
            showNotification('Theme updated successfully!');
        });
        
        // Change password button
        document.getElementById('changePasswordBtn').addEventListener('click', function() {
            showNotification('Password change initiated. Check your email!');
        });
        
        // Notification functionality
        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.querySelector('span').textContent = message;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
        
        // Simulate saving settings
        document.querySelectorAll('.toggle-switch input').forEach(switchEl => {
            if (switchEl.id !== 'themeToggle') {
                switchEl.addEventListener('change', function() {
                    showNotification('Settings updated successfully!');
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.body.classList.add('dark-theme');
        }
    });