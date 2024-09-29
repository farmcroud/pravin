<?php
require 'db_connect.php';

// Your SQL query and data saving logic here
$name = $_POST['name'];
$imagePath = $_POST['profileImage'];

// Insert user data into the database
$stmt = $pdo->prepare("INSERT INTO cards (name, image_path) VALUES (:name, :imagePath)");
$stmt->execute([':name' => $name, ':imagePath' => $imagePath]);

echo "Card saved successfully!";
?>
