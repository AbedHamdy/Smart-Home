// Common functionality for all pages
document.addEventListener('DOMContentLoaded', function() {
    // Add icons focus effect for all input fields
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="password"], input[type="number"], select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            const icon = this.nextElementSibling;
            if (icon && icon.classList.contains('input-icon')) {
                icon.style.transform = 'translateY(-50%) scale(1.1)';
                icon.style.color = '#059669';
            }
        });

        input.addEventListener('blur', function() {
            const icon = this.nextElementSibling;
            if (icon && icon.classList.contains('input-icon')) {
                icon.style.transform = 'translateY(-50%) scale(1)';
                icon.style.color = '#94a3b8';
            }
        });
    });

    // Auto-hide messages after 5 seconds
    const messages = document.querySelectorAll('.form-message');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 300);
        }, 5000);
    });
});