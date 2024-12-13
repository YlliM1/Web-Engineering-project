<?php

include '../../config.php';

function getAllUsers($conn) {
    $sql = "SELECT id, first_name, last_name, username, email, role FROM users";
    return $conn->query($sql);
}   


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="view_users.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<section id="admin-dashboard">
    <div class="nav-bar">
        <a href="../../main-page/main-page.php" class="icon nav-icon" title="Go to Main Page">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2>Admin Dashboard</h2>
        <a href="add_users.php" class="icon nav-icon" title="Add New User">
            <i class="fas fa-plus"></i>
        </a>
    </div>
    <p>Manage users below:</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = getAllUsers($conn);
            while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']); ?></td>
                <td><?= htmlspecialchars($user['first_name']); ?></td>
                <td><?= htmlspecialchars($user['last_name']); ?></td>
                <td><?= htmlspecialchars($user['username']); ?></td>
                <td><?= htmlspecialchars($user['email']); ?></td>
                <td><?= htmlspecialchars($user['role']); ?></td>
                <td>
                    <a href="edit_users.php?id=<?= $user['id']; ?>" class="icon edit-icon" title="Edit">
                        <i class="fas fa-pen"></i>
                    </a>
                    <form action="delete_users.php" method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                        <button type="submit" class="icon delete-icon" 
                        onclick="return confirm('Are you sure you want to delete this user?');" 
                        title="Delete">
                        <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>



        
</body>
</html>