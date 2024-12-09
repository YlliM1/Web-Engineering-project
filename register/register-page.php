<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../register/register-page.css">
</head>
<body>
    <video autoplay muted loop id="Background-video">
        <source src="../images/9694810-hd_1920_1080_25fps.mp4" type="video/mp4">
    </video>

    <div class="fullPage">
        <div class="wrapper">
            <form onsubmit="ValidateForm(event)" action="">
                <h1>Sign up</h1>
                <div class="FirstLastName">
                    <div class="firstName">
                        <input type="text" id="firstName" placeholder="First Name" name="" />
                        <span id="firstNameError" class="error"></span>
                    </div>
                    <div class="lastName">
                        <input type="text" id="lastName" placeholder="Last Name" name="" />
                        <span id="lastNameError" class="error"></span>
                    </div>
                </div>
                <div class="inputBox">
                    <input type="text" id="username" placeholder="Username" name="" />
                    <span id="usernameError" class="error"></span>
                </div>
                <div class="inputBox">
                    <input type="text" id="email" placeholder="Email" name="" />
                    <span id="emailError" class="error"></span>
                </div>
                <div class="inputBox">
                    <input type="password" id="password" placeholder="Password" name="" />
                    <span id="passwordError" class="error"></span>
                </div>
                <button type="submit">Register</button>
            </form>
        </div>
    </div>

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

           
            alert("Registration successful!");
        }
    </script>
</body>
</html>
