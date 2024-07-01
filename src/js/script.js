/*======== login page =========*/ 
const registerButton = document.getElementById("register");
const userButton = document.getElementById("user");
const container = document.getElementById("container");

registerButton.addEventListener("click", () => {
    container.classList.add("right-panel-active");
});

userButton.addEventListener("click", () => {
    container.classList.remove("right-panel-active");
});

function openModal(key) {
    // Open the modal
    document.getElementById('myModal').style.display = 'block';

    // Fetch data from the server using AJAX
    // Assuming you have a PHP file (getData.php) to handle the database query
    fetch('getData.php?key=' + key)
        .then(response => response.json())
        .then(data => {
            // Populate the input field with the retrieved data
            document.getElementById('dataInput').value = data.result;
        })
        .catch(error => console.error('Error:', error));
}

function closeModal() {
    // Close the modal
    document.getElementById('myModal').style.display = 'none';
}

// Submit form data using AJAX
document.getElementById('updateForm').addEventListener('submit', function (event) {
    event.preventDefault();

    let data = document.getElementById('dataInput').value;

    // Assuming you have a PHP file (updateData.php) to handle the database update
    fetch('updateData.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'data=' + data,
    })
    .then(response => response.json())
    .then(result => {
        // Handle the result, maybe close the modal or show a success message
        console.log(result);
    })
    .catch(error => console.error('Error:', error));
});

