<?php
require 'db_connect.php'; // Connect to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $imageData = $_POST['profileImage'];

    // Save the image to the server
    $imageParts = explode(";base64,", $imageData);
    $imageTypeAux = explode("image/", $imageParts[0]);
    $imageType = $imageTypeAux[1];
    $imageBase64 = base64_decode($imageParts[1]);

    // Unique image name
    $fileName = 'profile_' . uniqid() . '.' . $imageType;
    $filePath = 'uploads/' . $fileName;

    // Save the image on the server
    file_put_contents($filePath, $imageBase64);

    // Insert the data into the database
    $stmt = $pdo->prepare("INSERT INTO cards (name, image_path) VALUES (:name, :imagePath)");
    $stmt->execute([':name' => $name, ':imagePath' => $filePath]);

    // Return success response
    echo json_encode(['success' => true, 'message' => 'Card saved successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
