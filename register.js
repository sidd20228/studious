document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const username = document.getElementById('reg-username').value;
        const password = document.getElementById('reg-password').value;
        const name = document.getElementById('name').value;
        const dob = document.getElementById('dob').value;
        const messageDiv = document.getElementById('reg-message');

        fetch('register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username, password, name, dob }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.style.color = 'green';
                messageDiv.textContent = data.message;
                document.getElementById('registerForm').reset(); // Clear form on success
            } else {
                messageDiv.style.color = 'red';
                messageDiv.textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.style.color = 'red';
            messageDiv.textContent = 'An error occurred. Please try again.';
        });
    });
});
