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

if (!empty($country)) {
    $country = '%' . $country . '%'; 
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindParam(':country', $country, PDO::PARAM_STR);
} else {
    $stmt = $conn->query("SELECT * FROM countries");
}

// Execute the query
$stmt->execute();

// Fetch all results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<ul>
<?php if (count($results) > 0): ?>
    <?php foreach ($results as $row): ?>
        <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
    <?php endforeach; ?>
<?php else: ?>
    <li>No countries found matching the search.</li>
<?php endif; ?>
</ul>
