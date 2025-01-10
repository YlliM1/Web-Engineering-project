<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (empty($data['shoeName'])) {
    echo json_encode(['success' => false, 'message' => 'Shoe name is required.']);
    exit;
}

$shoeName = htmlspecialchars($data['shoeName']);
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
    exit;
}

try {
    $conn = new mysqli("localhost", "root", "", "shoe_shop");
    $stmt = $conn->prepare("INSERT INTO purchases (user_id, shoe_name) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $shoeName);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo json_encode(['success' => true, 'message' => 'Purchase successful']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error processing purchase: ' . $e->getMessage()]);
}
