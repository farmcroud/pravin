<?php
// Database connection settings
$servername = "your_database_host"; // Replace with DigitalOcean database host
$username = "your_database_user";  // Replace with your MySQL username
$password = "your_database_password";  // Replace with your MySQL password
$dbname = "profile_cards";  // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    // Handle profile image upload
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profilePicture']['tmp_name'];
        $fileName = basename($_FILES['profilePicture']['name']);
        $uploadFileDir = 'uploads/';
        $dest_path = $uploadFileDir . $fileName;

        // Move the uploaded file to the 'uploads' folder
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Save card data to the database
            $profileImagePath = $dest_path;
            $cardImagePath = "path_to_generated_card_image";  // Update this with your logic for saving card

            // Insert data into database
            $sql = "INSERT INTO profile_cards (user_name, profile_image, card_image) VALUES ('$name', '$profileImagePath', '$cardImagePath')";

            if ($conn->query($sql) === TRUE) {
                echo "Card saved successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "There was an error uploading the profile picture.";
        }
    }
}

// Close connection
$conn->close();
?>
