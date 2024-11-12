<?php
$servername = "localhost";
$username = "computer_inventory_manager";
$password = "b(79yKo8Ei";
$dbname = "computer_inventory";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to the database successfully!";
}
?>
