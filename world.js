document.getElementById('lookup').addEventListener('click', function (event) {
    event.preventDefault(); 

    var country = document.getElementById('country').value; // Get the value from the search box
    var url = 'world.php?country=' + encodeURIComponent(country); // Build the url with the search parameter

    fetch(url)
        .then(response => response.text())
        .then(data => {
            // Update the result div with the server's response
            document.getElementById('result').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
});

document.getElementById('city').addEventListener('click', function (event) {
    event.preventDefault(); 

    var country = document.getElementById('country').value;  
    var url = 'world.php?country=' + encodeURIComponent(country) + '&lookup=cities';  // Build the url with cities

    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('result').innerHTML = data;  // Insert the city into the result div
        })
        .catch(error => console.error('Error:', error));
});