
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
    <title>Manage Messages</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bayon&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="adminHeader.css">
    <link rel="stylesheet" href="manageUsersStyles.css">

</head>
<body>
    <?php 
    include "adminHeader.php";
    ?>

    <section class="hero">
        <h1>Manage Customer Messages</h1>
    </section>

    <div class="table-container">
        <div class="table-card">
            <h2 style="text-align: center; margin-bottom: 20px;">Received Messages</h2>

            <div style="text-align: right; margin-bottom: 15px;">
                <button onclick="clearAllMessages()" style="padding: 8px 16px; background-color: red; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    🧹 Clear All Messages
                </button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = Database::search("SELECT * FROM `message` ORDER BY msg_id DESC");
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$count}</td>";
                        echo "<td>" . htmlspecialchars($row["msg_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["msg_mail"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                        echo "<td>" . nl2br(htmlspecialchars($row["comment"])) . "</td>";
                        echo "</tr>";
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function clearAllMessages() {
            if (confirm("Are you sure you want to delete ALL messages? This action cannot be undone.")) {
                var request = new XMLHttpRequest();
                request.onreadystatechange = function () {
                    if (request.readyState === 4) {
                        if (request.responseText.trim() === "success") {
                            alert("All messages have been deleted.");
                            location.reload();
                        } else {
                            alert("Error clearing messages: " + request.responseText);
                        }
                    }
                };
                request.open("POST", "clear_all_messages.php", true);
                request.send();
            }
        }
    </script>
</body>
</html>
