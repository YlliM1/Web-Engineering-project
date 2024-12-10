
<?php 
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    
    if (!empty($username) && !empty($password)) {
        
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            
            if (password_verify($password, $user['password'])) {
               
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                
                header('Location: ../main-page/main-page.php');
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No user found with that username.";
        }
    } else {
        $error = "Please fill in both fields.";
    }
}

?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<link rel="stylesheet" href="../login/login.css">
<body>
    <video autoplay muted loop id="bck-video" src="../images/9694810-hd_1920_1080_25fps.mp4"></video>

    <div class="fullPage">
        <div class="loginForm">
            <form onsubmit="ValidateForm(event)" action="index.php" method ="post">
                <h1>Login</h1>

                <div class="inputBox">
                    <input type="text" id="username" placeholder="Username" name="username" />
                    <span id="usernameError" class="error"></span>
                </div>
                <div class="inputBox">
                    <input type="password" id="password" placeholder="Password" name="password" />
                    <span id="passwordError" class="error"></span>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script>
        function ValidateForm(event) {
        
            

        
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();

            
            const usernameError = document.getElementById("usernameError");
            const passwordError = document.getElementById("passwordError");

        
            usernameError.textContent = "";
            passwordError.textContent = "";


            if (username === "") {
                usernameError.textContent = "Username is required!";
                return;
            }
            if (username.length < 3) {
                usernameError.textContent = "Username must be longer than 3 characters!";
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
