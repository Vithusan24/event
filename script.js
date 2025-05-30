function validateForm() {
    const phone = document.getElementById('phone').value;
    const eventDate = document.getElementById('event_date').value;
    const phoneRegex = /^\+?\d{10,15}$/;
    const today = new Date().toISOString().split('T')[0];

    if (!phoneRegex.test(phone)) {
        alert('Please enter a valid phone number (10-15 digits, may start with +).');
        return false;
    }

    if (eventDate < today) {
        alert('Event date cannot be in the past.');
        return false;
    }

    return true;
}

function validateInquiryForm() {
    const email = document.getElementById('email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address.');
        return false;
    }

    return true;
}

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date for event date picker to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('event_date').min = today;
    
    // Add form validation if forms exist on page
    if (document.getElementById('phone')) {
        document.querySelector('form').onsubmit = validateForm;
    }
    
    if (document.getElementById('email')) {
        document.querySelector('form').onsubmit = validateInquiryForm;
    }
});