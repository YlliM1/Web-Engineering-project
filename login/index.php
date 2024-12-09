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
            <form onsubmit="ValidateForm(event)" action="">
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
        
            event.preventDefault();

        
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
            alert("Login successful!");
        }
    </script>
</body>
</html>
