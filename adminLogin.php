<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INGCO Login</title>
    <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="loginStyles.css">
    
</head>
<body>
    <!-- Header -->
  <!-- Navbar with Inline CSS -->
<header style="background-color: #FF9400; display: flex; justify-content: space-between; align-items: center; padding: 30px 20px;">
    <div class="logo" style="flex-shrink: 0;">
        <img src="assets/images/logo.png" alt="Logo" style="height: 50px;">
    </div>
    <nav>
        <ul style="list-style: none; display: flex; padding: 0; margin: 0;">
            <li style="margin: 0 40px; position: relative;">
                <a href="index.php" style="text-decoration: none; color: black; position: relative; padding-bottom: 5px; font-size: 25px; font-family: 'Inter';"
                   onmouseover="this.querySelector('span').style.width='100%';"
                   onmouseout="this.querySelector('span').style.width='0';">
                    HOME
                    <span style="content: ''; position: absolute; left: 50%; bottom: 0; width: 0; height: 2px; background-color: #000000; transition: all 0.3s ease-out; transform: translateX(-50%); display: block;"></span>
                </a>
            </li>
            <li style="margin: 0 40px; position: relative;">
                <a href="#" style="text-decoration: none; color: black; position: relative; padding-bottom: 5px; font-size: 25px; font-family: 'Inter';"
                   onmouseover="this.querySelector('span').style.width='100%';"
                   onmouseout="this.querySelector('span').style.width='0';">
                    SHOP
                    <span style="content: ''; position: absolute; left: 50%; bottom: 0; width: 0; height: 2px; background-color: #000000; transition: all 0.3s ease-out; transform: translateX(-50%); display: block;"></span>
                </a>
            </li>
            <li style="margin: 0 40px; position: relative;">
                <a href="#" style="text-decoration: none; color: black; position: relative; padding-bottom: 5px; font-size: 25px; font-family: 'Inter';"
                   onmouseover="this.querySelector('span').style.width='100%';"
                   onmouseout="this.querySelector('span').style.width='0';">
                    CONTACT
                    <span style="content: ''; position: absolute; left: 50%; bottom: 0; width: 0; height: 2px; background-color: #000000; transition: all 0.3s ease-out; transform: translateX(-50%); display: block;"></span>
                </a>
            </li>
            <li style="margin: 0 40px; position: relative;">
                <a href="#" style="text-decoration: none; color: black; position: relative; padding-bottom: 5px; font-size: 25px; font-family: 'Inter';"
                   onmouseover="this.querySelector('span').style.width='100%';"
                   onmouseout="this.querySelector('span').style.width='0';">
                    ABOUT
                    <span style="content: ''; position: absolute; left: 50%; bottom: 0; width: 0; height: 2px; background-color: #000000; transition: all 0.3s ease-out; transform: translateX(-50%); display: block;"></span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="user-cart" style="flex-shrink: 0;">
    </div>
</header>

    
    <!-- Hero Section -->
    <section class="hero">
        <div class="overlay">

        <div class="login-box">
        <h1 style="font-family: 'Bayon', sans-serif; color: white; font-size: 3rem; text-decoration: none;"> ADMIN LOG IN</h1>

            <h2>EMAIL</h2>
            <input type="email" id="adminemail" placeholder="">
            <h2>PASSWORD</h2>
            <input type="password" id="adminpassword" placeholder="">
            <button class="login-btn" onclick="Adminlogin()" >LOG IN</button>

        </div>
    </div>
    </section>

    <script>


// login function

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
    request.open("POST", "adminloginProcess.php", true);
    request.send(form);
}

    </script>
</body>
</html>
