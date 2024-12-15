<?php
include '../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: view_users.php?message=User+deleted+successfully");
            exit;
        } else {
            $stmt->close();
            header("Location: view_users.php?error=Failed+to+delete+user");
            exit;
        }
    } else {
        header("Location: view_users.php?error=Invalid+user+ID");
        exit;
    }
}
?>
