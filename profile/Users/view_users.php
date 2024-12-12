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
            <h2>Admin Dashboard</h2>
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
                        <a href="../admin/delete-user.php?id=<?= $user['id']; ?>" class="icon delete-icon" title="Delete" 
                            onclick="return confirm('Are you sure you want to delete this user?');">
                            <i class="fas fa-trash"></i>
                        </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
</body>
</html>