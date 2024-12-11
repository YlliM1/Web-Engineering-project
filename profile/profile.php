<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/index.php');
    exit;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';


function getUserData($conn, $userId) {
    $sql = "SELECT first_name, last_name, username, email FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


function getAllUsers($conn) {
    $sql = "SELECT id, first_name, last_name, username, email, role FROM users";
    return $conn->query($sql);
}

$userData = getUserData($conn, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../profile/profile.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Profile</h1>
            <nav>
                <ul>
                    <li><a href="../main-page/main-page.php">Home</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

       
        <section id="profile">
            <h2>Your Profile</h2>
            <p><strong>First Name:</strong> <?= htmlspecialchars($userData['first_name']); ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($userData['last_name']); ?></p>
            <p><strong>Username:</strong> <?= htmlspecialchars($userData['username']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($userData['email']); ?></p>
        </section>

       
        <?php if ($isAdmin): ?>
    <div class="admin-buttons">
        <a href="../profile/users/view_users.php">
            <button>View Users</button>
        </a>
        <a href="change_password.php">
            <button>Change Password</button>
        </a>
    </div>
<?php endif; ?>

    </div>
</body>
</html>
