<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thusitha Engineering | Login</title>
    <link href="https://fonts.googleapis.com/css?family=Bayon" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="loginStyles.css">
</head>
<body>
    <header class="auth-header">
        <a class="auth-logo" href="index.php">
            <img src="assets/Logo.jpg" alt="Thusitha Engineering logo">
        </a>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="overlay">
            <div class="login-box">
                <h1>Log in</h1>
                <h2>EMAIL</h2>
                <input type="email" id="email" placeholder="">
                <h2>PASSWORD</h2>
                <input type="password" id="password" placeholder="">
                <div class="forgetpw">
                    <p><a href="forgotPassword.php">Forgot Password?</a></p>
                </div>
                <button class="login-btn" onclick="login()">LOG IN</button>
                <p>No account? <a href="register.php">Register here</a></p>
                <p><a href="adminLogin.php">Admin login</a></p>
            </div>
        </div>
    </section>

    <script>
    function login() {
        var email = document.getElementById("email").value.trim();
        var password = document.getElementById("password").value.trim();

        if (email === "" || password === "") {
            alert("Please fill in all fields.");
            return;
        }

        var form = new FormData();
        form.append("email", email);
        form.append("password", password);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4) {
                var response = request.responseText;
                if (response == "done") {
                    window.location = "index.php";
                } else {
                    alert(response);
                }
            }
        };
        request.open("POST", "loginProcess.php", true);
        request.send(form);
    }
    </script>
</body>
</html>
