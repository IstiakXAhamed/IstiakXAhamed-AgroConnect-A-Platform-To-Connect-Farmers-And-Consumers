<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <script>
        function callAjax() {
            let username = document.getElementById("username").value.trim();
            let email = document.getElementById("email").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let password = document.getElementById("password").value.trim();
            let confirmPassword = document.getElementById("confirmPassword").value.trim();
            let role = document.getElementById("role").value.trim();
            let result = document.getElementById("result");
            //Error test text 
            let usernameError = document.getElementById("usernameError");
            let emailError = document.getElementById("emailError");
            let phoneError = document.getElementById("phoneError");
            let passwordError = document.getElementById("passwordError");
            let confirmPasswordError = document.getElementById("confirmPasswordError");
            let roleError = document.getElementById("roleError");

            usernameError.innerHTML = "";
            emailError.innerHTML = "";
            phoneError.innerHTML = "";
            passwordError.innerHTML = "";
            confirmPasswordError.innerHTML = "";
            roleError.innerHTML = "";
            result.innerHTML = "";
            hasError = false;

            if (username == "") {
                usernameError.innerHTML = "Username is required";
                hasError = true;
            }
            if (!/^[a-zA-Z0-9_]{6,20}$/.test(username)) {
                usernameError.innerHTML = "Username must be 6-20 characters and alphanumeric";
                hasError = true;
            }
            if (email == "") {
                emailError.innerHTML = "Email is required";
                hasError = true;
            }
            if (phone == "") {
                phoneError.innerHTML = "Phone is required";
                hasError = true;
            } else if (phone.length != 11) {
                phoneError.innerHTML = "Phone must be 11 characters";
                hasError = true;
            }
            if (password == "") {
                passwordError.innerHTML = "Password is required";
                hasError = true;
            } else if (password.length < 8) {
                passwordError.innerHTML = "Password must be 8 characters";
                hasError = true;
            }
            if (confirmPassword == "") {
                confirmPasswordError.innerHTML = "Confirm Password is required";
                hasError = true;
            } else if (confirmPassword !== password) {
                confirmPasswordError.innerHTML = "Passwords do not match";
                hasError = true;
            }
            if (role == "") {
                roleError.innerHTML = "Role is required";
                hasError = true;
            }

            if (!hasError) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "../Controller/AuthControl/registerController.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        try {
                            let jsObj = JSON.parse(xhr.responseText);

                            if (jsObj.success) {
                                result.style.color = "green";
                                result.innerHTML = jsObj.message;

                                // registration successful hole login page e pathai
                                setTimeout(function() {
                                    window.location.href = "login.php";
                                }, 2000);

                            } else {
                                result.style.color = "red";
                                result.innerHTML = jsObj.message;
                            }
                        } catch (e) {
                            result.innerHTML = "Server error";
                            console.log(xhr.responseText);
                        }
                    }
                }
                xhr.send("username=" + username + "&email=" + email + "&phone=" + phone + "&password=" + password + "&confirmPassword=" + confirmPassword + "&role=" + role);
            }

        }
    </script>
</head>

<body class="login-body">

    <div class="login-container">

        <div class="login-left">
            <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=800" alt="Farm" class="login-image">
            <div class="login-overlay">
                <div class="login-brand">AgroConnect</div>
                <div class="login-tagline">Connecting Farmers with Consumers</div>
            </div>
        </div>

        <div class="login-right">

            <h2 class="login-title">Create Account</h2>

            <p class="login-subtitle">Sign up to create an account</p>

            <!--form for collecting data --> 
            <form class="login-form">

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-input" placeholder="Enter your username">
                    <span id="usernameError" class="error-text"></span>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email">
                    <span id="emailError" class="error-text"></span>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-input" placeholder="Enter your phone number">
                    <span id="phoneError" class="error-text"></span>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password">
                    <span id="passwordError" class="error-text"></span>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-input" placeholder="Confirm your password">
                    <span id="confirmPasswordError" class="error-text"></span>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Register As</label>
                    <select name="role" id="role" class="form-input">
                        <option value="">Select Role</option>
                        <option value="farmer">Farmer</option>
                        <option value="customer">Customer</option>
                        <option value="transporter">Transporter</option>
                    </select>
                    <span id="roleError" class="error-text"></span>
                </div>

                <button type="button" onclick="callAjax()" class="login-btn">Sign Up</button>


                <span id="result" class="result-message"></span>

            </form>
            <div class="register-section">
                Already have an account? <a href="login.php" class="register-link">Sign In</a>
            </div>


        </div>

    </div>

</body>

</html>