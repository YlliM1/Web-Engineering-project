<?php
session_start();
include_once '../config.php';

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Check if the user is logged in and has an 'admin' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'You must be logged in as an admin to edit a shoe.']);
    exit;
}

// Get the raw POST data (JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Ensure the necessary data is present
$shoeId = $data['shoeId'] ?? null;
$shoeName = $data['shoeName'] ?? null;
$shoePrice = $data['shoePrice'] ?? null;

if (!$shoeId || !$shoeName || !$shoePrice) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

try {
    // Update the shoe in the database
    $stmt = $conn->prepare("UPDATE shoes SET name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("sdi", $shoeName, $shoePrice, $shoeId);
    $stmt->execute();
    
    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Shoe updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Shoe not found.']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error updating shoe: ' . $e->getMessage()]);
}

$conn->close();
?>
