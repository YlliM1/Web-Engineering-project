<?php
session_start();
include_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'You must be logged in as an admin to delete a shoe.']);
    exit;
}

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (empty($data['shoeId'])) {
    echo json_encode(['success' => false, 'message' => 'Shoe ID is required.']);
    exit;
}

$shoeId = $data['shoeId'];

// Prepare the SQL to delete the shoe
try {
    $stmt = $conn->prepare("DELETE FROM shoes WHERE id = ?");
    $stmt->bind_param("i", $shoeId);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Shoe deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Shoe not found.']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error deleting shoe: ' . $e->getMessage()]);
}

$conn->close();
?>
