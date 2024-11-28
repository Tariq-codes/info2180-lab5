<?php
$host = 'localhost';
$username = 'lab5_user'; 
$password = 'password123';  
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // For error handling
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$country = isset($_GET['country']) ? htmlspecialchars(trim($_GET['country'])) : '';

$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

if ($lookup === 'cities'){
    // fetch cities
    if (!empty($country)){
        $stmt = $conn->prepare("SELECT city.name, city.district, city.population FROM cities AS city JOIN countries AS country ON city.country_code = country.code WHERE country.name LIKE :country");
        $stmt->bindParam(':country', $country, PDO::PARAM_STR);
    } else {
        $stmt = $conn->query("SELECT city.name, city.district, city.population FROM cities AS city JOIN countries AS country ON city.country_code = country.code");
    }
} else {
    if (!empty($country)) {
        $country = '%' . $country . '%'; 
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->bindParam(':country', $country, PDO::PARAM_STR);
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
    }

}


// Execute the query
$stmt->execute();

// Fetch all results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// check if cities
if ($lookup === 'cities') {
    if (count($results) > 0) {
        echo '<table border="1">
                <thead>
                    <tr>
                        <th>City Name</th>
                        <th>District</th>
                        <th>Population</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($results as $row) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['district']) . '</td>
                    <td>' . htmlspecialchars($row['population']) . '</td>
            
                  </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo 'No cities found matching the search.';
    }
} else {
    // if country
    if (count($results) > 0) {
        echo '<table border="1">
                <thead>
                    <tr>
                        <th>Country Name</th>
                        <th>Continent</th>
                        <th>Independence Year</th>
                        <th>Head of State</th>
                    </tr>
                </thead>
                <tbody>';
             foreach ($results as $row) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['continent']) . '</td>
                    <td>' . htmlspecialchars($row['independence_year']) . '</td>
                    <td>' . htmlspecialchars($row['head_of_state']) . '</td>
                  </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo 'No countries found matching the search.';
    }
}
