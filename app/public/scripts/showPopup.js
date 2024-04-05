function showSuccessMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.textContent = message;
    messageDiv.className = 'success-message-popup';
    document.body.appendChild(messageDiv);

    messageDiv.style.display = 'block';

    setTimeout(function() {
        document.body.removeChild(messageDiv);
    }, 500);
}

function showErrorMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.textContent = message;
    messageDiv.className = 'error-message-popup';
    document.body.appendChild(messageDiv);

    messageDiv.style.display = 'block';

    setTimeout(function() {
        document.body.removeChild(messageDiv);
    }, 5000);
}
