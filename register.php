<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thusitha Engineering | Register</title>
    <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="registerStyles.css">
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">
            <img src="assets/images/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="#">SHOP</a></li>
                <li><a href="#">CONTACT</a></li>
                <li><a href="#">ABOUT</a></li>
            </ul>
        </nav>
        <div class="user-cart">
            
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="overlay">
            <div class="register-box">
                <div class="form-container">
                    <!-- Left column -->
                    <div class="column">
                        <h2>NAME</h2>
                        <input type="text" id="username" required>
                        <h2>EMAIL</h2>
                        <input type="email" id="useremail" required>
                        <h2>TELEPHONE NUMBER</h2>
                        <input type="tel" id="usertele" required>
                    </div>

                    <!-- Right column -->
                    <div class="column">
                        <h2>ADDRESS</h2>
                        <input type="text" id="useraddress" required>
                        <h2>PASSWORD</h2>
                        <input type="password" id="userpassword" required>
                        <h2>CONFIRM PASSWORD</h2>
                        <input type="password" id="confirmPassword" required>
                    </div>

                    <!-- Upload Picture Box -->
                    <div class="upload-box">
                        <h2>UPLOAD PROFILE PICTURE</h2>
                        <div class="upload-area" id="uploadArea">
                            <input type="file" id="fileInput" accept="image/*" hidden>
                            <label for="fileInput" class="upload-label">Click to Upload</label>
                            <img id="previewImage" src="" alt="Profile Picture" style="display: none;">
                        </div>
                    </div>
                </div>

                <button class="register-btn" onclick="register()">SIGN UP</button>
                <p>Already Have an Account ? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </section>

    <script>
        // Profile picture upload preview
        document.getElementById('fileInput').addEventListener('change', function(event) {
            let file = event.target.files[0]; 
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.getElementById('previewImage');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    document.querySelector('.upload-label').style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('uploadArea').addEventListener('click', function() {
            document.getElementById('fileInput').click();
        });

        // User registration function
        function register() {
    var namer = document.getElementById("username").value.trim();
    var emailr = document.getElementById("useremail").value.trim();
    var teler = document.getElementById("usertele").value.trim();
    var adressr = document.getElementById("useraddress").value.trim();
    var passwordr = document.getElementById("userpassword").value.trim();
    var confirmPass = document.getElementById("confirmPassword").value.trim();
    var fileInput = document.getElementById("fileInput").files[0];

    // Check if required fields are filled
    if (!namer || !emailr || !teler || !adressr || !passwordr || !confirmPass) {
        alert("Please fill in all required fields.");
        return;
    }

    // Validate phone number (exactly 10 digits)
    if (!/^\d{10}$/.test(teler)) {
        alert("Telephone number must be exactly 10 digits.");
        return;
    }

    // Validate password and confirm password
    if (passwordr !== confirmPass) {
        alert("Passwords do not match.");
        return;
    }

    var form = new FormData();
    form.append("username", namer);
    form.append("useremail", emailr);
    form.append("usertele", teler);
    form.append("useraddress", adressr);
    form.append("userpassword", passwordr);

    if (fileInput) {
        form.append("fileInput", fileInput);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            if (response === "done") {
                window.location = "login.php";
            } else {
                alert(response);
            }
        }
    };

    request.open("POST", "registerProcess.php", true);
    request.send(form);
}
    </script>
</body>
</html>
