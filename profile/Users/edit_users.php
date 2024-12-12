<?php
include '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; 


    $sql = "UPDATE users SET
        first_name='$firstName',
        last_name='$lastName',
        username='$username',
        email='$email',
        password='$password',
        role='$role'  
        WHERE id='$id'";


    if ($conn->query($sql) === TRUE) {
        header('Location: view_users.php');
        exit; 
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


    <?php
 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
       
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

<h2>Edit User:</h2>
<form action="edit_users.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

    <div class="row">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required>
    </div>
    <div class="row">
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required>
    </div>

    <div class="row">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
    </div>

    <div class="row">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
    </div>

    <div class="row">
        <label for="password">Password:</label>
        <input type="password" name="password" value="<?php echo $user['password']; ?>" required>
    </div>

    <div class="row">
        <label for="role">Role:</label>
        <select name="role" required>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
        </select>
    </div>

    <input type="submit" value="Update User">
    <a href="../profile/profile.php"><button class="Profile_button">Back to Profile</button></a>
</form>

</body>
</html>
