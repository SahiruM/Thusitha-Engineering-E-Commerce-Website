<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "2003";
$dbname = "thusitha";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userID = $_POST['user_id'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Delete from customer_table
        $stmt1 = $conn->prepare("DELETE FROM `customer_table` WHERE `customer_id` = ?");
        $stmt1->bind_param("i", $userID);
        $stmt1->execute();
        $stmt1->close();

        // Delete from user table (assuming `user_id` matches `customer_id`)
        $stmt2 = $conn->prepare("DELETE FROM `user` WHERE `id` = ?");
        $stmt2->bind_param("i", $userID);
        $stmt2->execute();
        $stmt2->close();

        // Commit transaction
        $conn->commit();
        echo "success";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error deleting user: " . $e->getMessage();
    }
} else {
    echo "No valid data received";
}

$conn->close();
?>
