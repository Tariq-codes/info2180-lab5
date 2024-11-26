document.getElementById('lookup').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent the form from submitting normally

    var country = document.getElementById('country').value; // Get the value from the search box
    var url = 'world.php?country=' + encodeURIComponent(country); // Build the URL with the search parameter

    fetch(url)
        .then(response => response.text())
        .then(data => {
            // Update the result div with the server's response
            document.getElementById('result').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
});
