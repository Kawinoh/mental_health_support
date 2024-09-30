document.addEventListener('DOMContentLoaded', () => {
    const confirmationMessage = document.getElementById('confirmationMessage');
    
    // Example function to show confirmation message after booking
    const showConfirmation = () => {
        confirmationMessage.style.display = 'block';
    };

    // Assuming the booking process is handled successfully
    // You may want to call showConfirmation() after a successful form submission
});
