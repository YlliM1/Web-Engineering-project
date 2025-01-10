<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: ../login/index.php');
    exit;
}

require_once '../config.php'; // Adjust the path to your database config file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shoeName = $_POST['shoeName'];
    $shoePrice = $_POST['shoePrice'];

    if (isset($_FILES['shoeImage']) && $_FILES['shoeImage']['error'] === 0) {
        $uploadDir = '../images/';
        $fileName = basename($_FILES['shoeImage']['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['shoeImage']['tmp_name'], $targetFilePath)) {
            $shoeImage = $fileName;

            $sql = "INSERT INTO shoes (name, price, image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sds", $shoeName, $shoePrice, $shoeImage);

            if ($stmt->execute()) {
                header("Location: main-page.php");
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid image file.";
    }
}
?>
