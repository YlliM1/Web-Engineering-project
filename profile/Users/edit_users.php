<?php
include '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch the form data
    $id = $_POST['id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Assuming role is also part of the form data, if not remove this line

    // Update query
    $sql = "UPDATE users SET
        first_name='$firstName',
        last_name='$lastName',
        username='$username',
        email='$email',
        password='$password',
        role='$role'   -- Assuming you want to update the role too
        WHERE id='$id'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        header('Location: view_users.php');
        exit; // Ensure the script stops executing after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="edit_users.css">
</head>
<body>
    <h2>Edit User</h2>

    <?php
    // Assuming the 'id' is passed in the URL or as a parameter
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the user's data from the database
        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // Fetch user data
            $user = $result->fetch_assoc();
        } else {
            echo "User not found.";
            exit;
        }
    } else {
        echo "Invalid User ID.";
        exit;
    }
    ?>

    <!-- Edit user form -->
    <form action="edit_users.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required><br><br>

        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" value="<?php echo $user['password']; ?>" required><br><br>

        <label for="role">Role:</label>
        <select name="role" required>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
            <!-- Add more roles as needed -->
        </select><br><br>

        <input type="submit" value="Update User">
    </form>
</body>
</html>
