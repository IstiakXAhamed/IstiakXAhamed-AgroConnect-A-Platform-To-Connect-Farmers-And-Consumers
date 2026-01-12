<?php
// Remember Me cookie check
$rememberedEmail = isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : '';
$rememberedPass = isset($_COOKIE['remember_pass']) ? base64_decode($_COOKIE['remember_pass']) : '';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - AgroConnect</title>
    <link rel="stylesheet" href="login.css">

    <script>
        function callAjax() {
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            let result = document.getElementById("result");

            document.getElementById("emailError").innerHTML = "";
            document.getElementById("passwordError").innerHTML = "";
            result.innerHTML = "";

            if (email == "") {
                document.getElementById("emailError").innerHTML = "Email is required";
                return;
            }
            if (password == "") {
                document.getElementById("passwordError").innerHTML = "Password is required";
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../Controller/AuthControl/loginController.php")
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    try {
                        let jsObj = JSON.parse(xhr.responseText);
                        if (jsObj.success) {
                            window.location.href = jsObj.redirect;
                        } else {
                            result.innerHTML = jsObj.message;
                        }
                    } catch (e) {
                        result.innerHTML = "Server error";
                        console.log(xhr.responseText);
                    }
                }
            }
            // Remember checkbox value
            let remember = document.getElementById("remember").checked;

            xhr.send("email=" + email + "&password=" + password + "&remember=" + remember);
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

            <h2 class="login-title">Welcome Back</h2>
            <p class="login-subtitle">Sign in to your account</p>

            <form id="loginForm" class="login-form">

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" value="<?php echo htmlspecialchars($rememberedEmail); ?>">
                    <span id="emailError" class="error-text"></span>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" value="<?php echo htmlspecialchars($rememberedPass); ?>">
                    <span id="passwordError" class="error-text"></span>
                </div>

                <div class="form-options">
                    <label class="remember-label">
                        <input type="checkbox" id="remember" name="remember" <?php echo $rememberedEmail ? 'checked' : ''; ?>> Remember Me
                    </label>
                    <!-- <a href="forgotPassword.php" class="forgot-link">Forgot Password?</a> -->
                </div>

                <button type="button" onclick="callAjax()" class="login-btn">Sign In</button>
                <span id="result" class="result-message"></span>

            </form>

            <div class="register-section">
                Don't have an account? <a href="register.php" class="register-link">Sign Up</a>
            </div>

        </div>

    </div>

</body>

</html>