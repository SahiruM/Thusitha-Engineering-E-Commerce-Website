<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thusitha Engineering | Admin Login</title>
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
                <h1>Admin log in</h1>
                <h2>Email</h2>
                <input type="email" id="adminemail">
                <h2>Password</h2>
                <input type="password" id="adminpassword">
                <button class="login-btn" onclick="Adminlogin()">Log in</button>
                <p><a href="login.php">Customer login</a></p>
            </div>
        </div>
    </section>

    <script>
    function Adminlogin() {
        var adminemail = document.getElementById("adminemail").value.trim();
        var adminpassword = document.getElementById("adminpassword").value.trim();

        if (adminemail === "" || adminpassword === "") {
            alert("Please fill in all fields.");
            return;
        }

        var form = new FormData();
        form.append("adminemail", adminemail);
        form.append("adminpassword", adminpassword);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4) {
                var response = request.responseText;
                if (response == "done") {
                    window.location = "Dashboard.php";
                } else {
                    alert(response);
                }
            }
        };
        request.open("POST", "adminLoginProcess.php", true);
        request.send(form);
    }
    </script>
</body>
</html>
