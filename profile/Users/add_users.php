<?php
include '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

 
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (first_name, last_name, username, email, password, role)
            VALUES ('$firstName', '$lastName', '$username', '$email', '$hashedPassword', '$role')";

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
    <title>Add User</title>
    <link rel="stylesheet" href="add_users.css">
</head>
<body>

<h2>Add User:</h2>
<form action="add_users.php" method="POST" onsubmit="ValidateForm(event)">
    <div class="row">
        <label for="first_name">First Name:</label>
        <input type="text" id="firstName" name="first_name" value="">
        <span id="firstNameError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="last_name">Last Name:</label>
        <input type="text" id="lastName" name="last_name" value="">
        <span id="lastNameError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="">
        <span id="usernameError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="">
        <span id="emailError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="">
        <span id="passwordError" style="color: red;"></span>
    </div>

    <div class="row">
        <label for="role">Role:</label>
        <select name="role" >
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>

    <input type="submit" value="Add User">
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

        let formIsValid = true;

        if (firstName === "") {
            firstNameError.textContent = "First Name is required!";
            formIsValid = false;
        } else if (firstName.length < 3) {
            firstNameError.textContent = "First Name must be longer than 3 characters!";
            formIsValid = false;
        }

        if (lastName === "") {
            lastNameError.textContent = "Last Name is required!";
            formIsValid = false;
        } else if (lastName.length < 3) {
            lastNameError.textContent = "Last Name must be longer than 3 characters!";
            formIsValid = false;
        }

        if (username === "") {
            usernameError.textContent = "Username is required!";
            formIsValid = false;
        } else if (username.length < 3) {
            usernameError.textContent = "Username must be longer than 3 characters!";
            formIsValid = false;
        }

        if (email === "") {
            emailError.textContent = "Email is required!";
            formIsValid = false;
        } else if (!isValidEmail(email)) {
            emailError.textContent = "Invalid email format!";
            formIsValid = false;
        }

        if (password === "") {
            passwordError.textContent = "Password is required!";
            formIsValid = false;
        } else if (password.length < 6) {
            passwordError.textContent = "Password must be at least 6 characters long!";
            formIsValid = false;
        }

        if (formIsValid) {
            event.target.submit();
        }
    }
</script>

</body>
</html>
