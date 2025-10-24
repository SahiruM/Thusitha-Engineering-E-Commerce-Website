<?php
require "connection.php";
$id = $_GET['id'];
$order = Database::search("SELECT * FROM `checkout` WHERE `id` = '$id'");
$data = $order->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Order</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      background-color: #f4f4f4;
      color: #333;
    }

    .table-container {
      display: flex;
      justify-content: center;
      margin: 40px 0 80px;
    }

    .table-card {
      background-color: #000;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 1000px;
      color: white;
      overflow-x: auto;
    }

    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
    }

    input, select {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 15px;
      font-size: 16px;
    }

    .action-btn {
      padding: 10px 20px;
      border-radius: 6px;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 16px;
    }

    .edit-btn {
      background-color: #007bff;
    }

    .edit-btn:hover {
      background-color: #0056b3;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="table-container">
    <div class="table-card">
      <h2>Edit Order</h2>
      <form method="POST" action="update_order.php">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $data['name']; ?>">

        <label>Address</label>
        <input type="text" name="shipping_address" value="<?php echo $data['shipping_address']; ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $data['email']; ?>">

        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo $data['phone']; ?>">

        <label>Payment</label>
        <select name="payment">
          <option value="cash" <?php if ($data['payment_method'] == 'cash') echo 'selected'; ?>>Cash</option>
          <option value="bank" <?php if ($data['payment_method'] == 'bank') echo 'selected'; ?>>Bank</option>
        </select>

        <button class="action-btn edit-btn" type="submit">Update Order</button>
      </form>
    </div>
  </div>
</body>
</html>
