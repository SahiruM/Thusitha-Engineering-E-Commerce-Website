<?php

session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: adminLogin.php");
    exit();
}

require "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="manageUsersStyles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bayon&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="adminHeader.css">
</head>
<body>
   
<?php 
    include "adminHeader.php";
    ?>
    <section class="hero">
        <h1>Manage Users</h1>
    </section>


    <div class="table-container">
        <div class="table-card">
            <h2>Registered Users</h2>
            <button class="report-action" onclick="window.location.href='generateRecentSignupReport.php';">Download Report (PDF)</button>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Registration Date</th>
                        <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = Database::search("SELECT * FROM `customer_table` ORDER BY registered_date DESC");
                    while ($user = $users->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $user["customer_id"]; ?></td>
                        <td><?php echo $user["customer_name"]; ?></td>
                        <td><?php echo $user["customer_email"]; ?></td>
                        <td><?php echo $user["customer_telephone"]; ?></td>
                        <td><?php echo $user["registered_date"]; ?></td>
                        <td>
                            <button class="action-btn delete-btn" onclick="deleteUser(<?php echo $user['customer_id']; ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete user ID " + userId + "?")) {
                var form = new FormData();
                form.append("user_id", userId);

                var request = new XMLHttpRequest();
                request.onreadystatechange = function () {
                    if (request.readyState === 4) {
                        var response = request.responseText;

                        if (response === "success") {
                            alert("User deleted successfully.");
                            location.reload();
                        } else {
                            alert("Error: " + response);
                        }
                    }
                };
                request.open("POST", "remove_user.php", true);
                request.send(form);
            }
        }
    </script>
</body>
</html>
