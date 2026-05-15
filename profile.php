<?php
session_start();
require "connection.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION["user"];
$user_email = $user["customer_email"];

$result = Database::select("SELECT * FROM customer_table WHERE customer_email = ?", "s", $user_email);
$user_data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thusitha Engineering | Profile</title>
    <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="registerStyles.css">
    <link rel="stylesheet" href="header.css" />
    <link rel="stylesheet" href="footer.css">
</head>
<body>

<?php include "header.php"; ?>


<section class="hero">
    <div class="overlay">
        <div class="register-box">
            <div class="form-container">
                <!-- Left Column -->
                <div class="column">
                    <h2>NAME</h2>
                    <input type="text" id="username" value="<?= htmlspecialchars($user_data['customer_name']) ?>" disabled>
                    
                    <h2>EMAIL</h2>
                    <input type="email" id="useremail" value="<?= htmlspecialchars($user_data['customer_email']) ?>" disabled>
                    
                    <h2>TELEPHONE NUMBER</h2>
                    <input type="tel" id="usertele" value="<?= htmlspecialchars($user_data['customer_telephone']) ?>" disabled>
                </div>

                <!-- Right Column -->
                <div class="column">
                    <h2>ADDRESS</h2>
                    <input type="text" id="useraddress" value="<?= htmlspecialchars($user_data['customer_address']) ?>" disabled>

                    <h2>PASSWORD</h2>
                    <input type="password" id="userpassword" placeholder="Enter new password" disabled>

                    <h2>CONFIRM PASSWORD</h2>
                    <input type="password" id="confirmPassword" placeholder="Confirm new password" disabled>
                </div>

                <!-- Profile Picture Upload -->
                <div class="upload-box">
                    <h2>PROFILE PICTURE</h2>
                    <div class="upload-area" id="uploadArea">
                        <input type="file" id="fileInput" accept="image/*" hidden>
                        <label for="fileInput" class="upload-label" style="display:none;">Click to Upload</label>
                        <img id="previewImage" src="<?= htmlspecialchars($user_data['customer_pp']) ?>" alt="Profile Picture" style="display: block;">
                    </div>
                </div>
            </div>

            <button class="register-btn" id="editBtn" onclick="enableEdit()">EDIT</button>
            <button class="register-btn" style="display:none;" id="saveBtn" onclick="updateProfile()">SAVE</button>
        </div>
    </div>
</section>
<?php include "footer.php"; ?>

<script src="script.js"></script>
<script>
    let editMode = false;

    function enableEdit() {
        let fields = document.querySelectorAll("input");
        fields.forEach(f => f.disabled = false);

        document.querySelector('.upload-label').style.display = 'block';
        document.getElementById("editBtn").style.display = "none";
        document.getElementById("saveBtn").style.display = "block";

        editMode = true; // enable edit mode
    }

    // Only allow file input when in edit mode
    document.getElementById('uploadArea').addEventListener('click', function () {
        if (editMode) {
            document.getElementById('fileInput').click();
        }
    });

    document.getElementById('fileInput').addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.getElementById('previewImage');
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    function updateProfile() {
        let name = document.getElementById("username").value.trim();
        let email = document.getElementById("useremail").value.trim();
        let tele = document.getElementById("usertele").value.trim();
        let address = document.getElementById("useraddress").value.trim();
        let password = document.getElementById("userpassword").value.trim();
        let confirmPass = document.getElementById("confirmPassword").value.trim();
        let file = document.getElementById("fileInput").files[0];

        if (password && password !== confirmPass) {
            alert("Passwords do not match.");
            return;
        }

        let formData = new FormData();
        formData.append("username", name);
        formData.append("useremail", email);
        formData.append("usertele", tele);
        formData.append("useraddress", address);
        formData.append("userpassword", password);
        if (file) formData.append("fileInput", file);

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                alert(xhr.responseText);
                location.reload();
            }
        };
        xhr.open("POST", "updateProfile.php", true);
        xhr.send(formData);
    }

</script>
</body>
</html>
