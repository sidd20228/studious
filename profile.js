document.addEventListener('DOMContentLoaded', function () {
    // Check if user is logged in
    fetch('get_user.php')
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                document.getElementById('welcomeMessage').textContent = `Welcome, ${data.name}`;
                document.getElementById('dob').textContent = `Date of Birth: ${data.dob}`;
            } else {
                window.location.href = 'index.html';
            }
        })
        .catch(error => console.error('Error fetching user data:', error));

    // Timer
    let startTime = Date.now();
    setInterval(function () {
        let elapsedTime = Date.now() - startTime;
        let hours = Math.floor(elapsedTime / 3600000);
        let minutes = Math.floor((elapsedTime % 3600000) / 60000);
        let seconds = Math.floor((elapsedTime % 60000) / 1000);
        document.getElementById('timer').textContent = 
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');
    }, 1000);

    // To-do list
    const todoList = document.getElementById('todo-items');
    const newTodoInput = document.getElementById('new-todo');
    const addTodoButton = document.getElementById('add-todo');

    addTodoButton.addEventListener('click', function () {
        const taskText = newTodoInput.value.trim();
        if (taskText) {
            const li = document.createElement('li');
            li.textContent = taskText;
            li.addEventListener('click', function () {
                li.classList.toggle('completed');
            });
            todoList.appendChild(li);
            newTodoInput.value = '';
        }
    });

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', function () {
        fetch('logout.php')
            .then(response => response.text())
            .then(() => {
                window.location.href = 'index.html';
            });
    });
});
