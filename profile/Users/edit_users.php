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
<form action="edit_users.php" method="POST" onsubmit="ValidateForm(event)">
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

    <div class="row">
        <label for="first_name">First Name:</label>
        <input type="text" id="firstName" name="first_name" value="<?php echo $user['first_name']; ?>" required>
        <span id="firstNameError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="last_name">Last Name:</label>
        <input type="text" id="lastName" name="last_name" value="<?php echo $user['last_name']; ?>" required>
        <span id="lastNameError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
        <span id="usernameError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        <span id="emailError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" required>
        <span id="passwordError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="role">Role:</label>
        <select name="role" required>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
        </select>
    </div>

    <input type="submit" value="Update User">
    

    <button type="button" class="Profile_button" onclick="window.location.href='../profile.php';">Back to Profile</button>
</form>

<script>
    function isValidEmail(email) {
        const emailRegex = /^\S+@\S+\.\S+$/;
        return emailRegex.test(email);
    }

    function ValidateForm(event) {
        event.preventDefault();

        const firstName = document.getElementById("firstName").value.trim();
        const lastName = document.getElementById("lastName").value.trim();
        const username = document.getElementById("username").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        const firstNameError = document.getElementById("firstNameError");
        const lastNameError = document.getElementById("lastNameError");
        const usernameError = document.getElementById("usernameError");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");

        firstNameError.textContent = "";
        lastNameError.textContent = "";
        usernameError.textContent = "";
        emailError.textContent = "";
        passwordError.textContent = "";

        if (firstName === "") {
            firstNameError.textContent = "First Name is required!";
            return;
        }
        if (firstName.length < 3) {
            firstNameError.textContent = "First Name must be longer than 3 characters!";
            return;
        }

        if (lastName === "") {
            lastNameError.textContent = "Last Name is required!";
            return;
        }
        if (lastName.length < 3) {
            lastNameError.textContent = "Last Name must be longer than 3 characters!";
            return;
        }

        if (username === "") {
            usernameError.textContent = "Username is required!";
            return;
        }
        if (username.length < 3) {
            usernameError.textContent = "Username must be longer than 3 characters!";
            return;
        }

        if (email === "") {
            emailError.textContent = "Email is required!";
            return;
        }
        if (!isValidEmail(email)) {
            emailError.textContent = "Invalid email format!";
            return;
        }

        if (password === "") {
            passwordError.textContent = "Password is required!";
            return;
        }
        if (password.length < 6) {
            passwordError.textContent = "Password must be at least 6 characters long!";
            return;
        }
        event.target.submit();
    }
</script>

</body>
</html>
