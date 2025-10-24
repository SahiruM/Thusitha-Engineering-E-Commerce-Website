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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Page - Manage Orders</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="manageOrdersStyles.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bayon&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="adminHeader.css">
</head>
<body>
<?php 
    include "adminHeader.php";
    ?>

  <section class="hero">
    <h1>MANAGE ORDERS</h1>
  </section>

  <div class="table-container">
    <div class="table-card">
      <h2 style="text-align: center; margin-bottom: 20px;">Placed Orders</h2>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Payment</th>
            <th>Manage</th>
          </tr>
          <button onclick="window.location.href='generateOrdersReport.php';" style="margin-left: 2px; padding: 8px 16px; background-color:rgb(7, 248, 176); color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Download Report (PDF) </button>
        </thead>
        <tbody>
          <?php
            $orders = Database::search("SELECT * FROM `checkout`");
            while ($order = $orders->fetch_assoc()) {
          ?>
            <tr>
              <td><?php echo $order["id"]; ?></td>
              <td><?php echo $order["name"]; ?></td>
              <td><?php echo $order["shipping_address"]; ?></td>
              <td><?php echo $order["email"]; ?></td>
              <td><?php echo $order["phone"]; ?></td>
              <td><?php echo $order["payment_method"]; ?></td>
              <td>
                <button class="action-btn edit-btn" onclick="editOrder(<?php echo $order['id']; ?>)">Edit</button>
                <button class="action-btn delete-btn" onclick="deleteOrder(<?php echo $order['id']; ?>)">Delete</button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function deleteOrder(orderId) {
      if (confirm("Are you sure you want to delete order ID " + orderId + "?")) {
        const form = new FormData();
        form.append("order_id", orderId);

        fetch("remove_order.php", {
          method: "POST",
          body: form
        })
        .then(res => res.text())
        .then(data => {
          if (data === "success") {
            alert("Order deleted successfully.");
            location.reload();
          } else {
            alert("Error: " + data);
          }
        });
      }
    }

    function editOrder(orderId) {
      window.location.href = "edit_order.php?id=" + orderId;
    }
  </script>
</body>
</html>
