<?php
session_start();
require "connection.php";
if (!isset($_SESSION["admin"])) {
    header("Location: adminLogin.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Page - Add Product</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bayon&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="adminHeader.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      background-color:rgb(37, 37, 37);
      color: #333;
    }

    .header {
      background-color: #ffa500;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    .nav-links a {
      text-decoration: none;
      color: white;
      font-weight: 500;
      transition: color 0.3s;
    }

    .nav-links a:hover {
      color: #000;
    }

    .hero {
      background: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158') center/cover no-repeat;
      text-align: center;
      padding: 80px 20px;
      color: white;
      background-color: #222;
    }

    .hero h1 {
      font-size: 36px;
      font-weight: 700;
      text-shadow: 2px 2px 4px #000;
    }

    .form-container {
      display: flex;
      justify-content: center;
      margin-top: 40px;
      margin-bottom: 60px;
    }

    .form-card {
      background-color: #000;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
      width: 400px;
      color: white;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: 500;
      margin-bottom: 8px;
    }

    input[type="text"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 8px;
      background-color: #f9f9f9;
      font-size: 16px;
    }

    button {
      background-color: #ffa500;
      color: #fff;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      width: 100%;
      margin-top: 10px;
      transition: background 0.3s;
      font-size: 16px;
    }

    button:hover {
      background-color: #ff8c00;
    }

    .table-container {
      display: flex;
      justify-content: center;
      margin-bottom: 80px;
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

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 12px;
      text-align: center;
    }

    th {
      background-color: #ffa500;
    }

    tr:nth-child(even) {
      background-color: #1e1e1e;
    }

    .status-badge {
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 14px;
      display: inline-block;
    }

    .in-stock {
      background-color: #28a745;
    }

    .out-stock {
      background-color: #dc3545;
    }

    .edit-btn {
      background-color: #007bff;
      padding: 8px 16px;
      border-radius: 6px;
      border: none;
      color: white;
      cursor: pointer;
    }

    .edit-btn:hover {
      background-color: #0056b3;
    }

    .product-image {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
  </style>
</head>
<body>
<?php 
    include "adminHeader.php";
    ?>

  <!-- Hero section -->
  <section class="hero">
    <h1>ADD NEW PRODUCT</h1>
  </section>

  <!-- Add Product Form -->
  <div class="form-container">
    <div class="form-card">
      <div class="form-group">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>
      </div>

      <div class="form-group">
        <label for="stockCount">Stock Count:</label>
        <input type="text" id="stockCount" name="stockCount" required>
      </div>

      <div class="form-group">
        <label for="productPrice">Price (Rs):</label>
        <input type="text" id="productPrice" name="productPrice" required>
      </div>

      <div class="form-group">
        <label for="productImage">Product Image:</label>
        <input type="file" id="productImage" name="productImage" accept="image/*" required>
      </div>

      <button onclick="adProduct()">Add Product</button>
    </div>
  </div>

  <!-- Product Table -->
  <div class="table-container">
    <div class="table-card">
      <h2 style="text-align: center; margin-bottom: 20px;">Edit Existing Products</h2>
      <table>
        <thead>
          <tr>
            <th>Product Name</th>

            <th>Price (Rs)</th>
            <th>Stock</th>
           
            <th>Status</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="productTableBody">
         

          <?php

      $products = Database::search("SELECT * FROM `product`");
      while ($product = $products->fetch_assoc()) {
      ?>
        <tr>
            <td><?php echo ($product["product_name"]) ?></td>
            <td>Rs.<?php echo ($product["price"]) ?>.00</td>
            <td><?php echo ($product["stock"]) ?></td>

            <?php
               if($product["stock"]==0){

                ?>  <td><span class="status-badge out-stock">Out of Stock</span></td> <?php
               }else{
                ?>  <td><span class="status-badge in-stock">In Stock</span></td><?php
               }
            ?>
           
           
            
            <td><img src="<?php echo ($product["img"]) ?>" alt="Drill" class="product-image"></td>
            <td><button onclick="adminModel(<?php echo ($product['product_id']) ?>)" class="edit-btn">Edit</button></td>

            <td><button onclick="Delete(<?php echo ($product['product_id']) ?>)" class="edit-btn">Delete</button></td>
          </tr>
      <?php
      }
      ?>
         
        </tbody>
      </table>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
    background-color: rgba(0,0,0,0.7); justify-content: center; align-items: center; z-index: 1000;">
    <div class="form-card" style="position: relative; max-width: 400px; width: 90%;">
      <span onclick="closeModal()" style="position: absolute; top: 10px; right: 16px; cursor: pointer; color: white; font-size: 20px;">&times;</span>
      <div class="form-group">
        <label for="editProductName">Product Name:</label>
        <input type="text" id="editProductName" name="editProductName" required>
      </div>

      <div class="form-group">
        <label for="editStockCount">Stock Count:</label>
        <input type="text" id="editStockCount" name="editStockCount" required>
      </div>

      <div class="form-group">
        <label for="editProductPrice">Price (Rs):</label>
        <input type="text" id="editProductPrice" name="editProductPrice" required>
      </div>

      <div class="form-group">
        <label for="editProductImage">Product Image:</label>
        <input type="file" id="editProductImage" name="editProductImage" accept="image/*" required>
      </div>

      <button id="editProductSave" >Save Changes</button>
    </div>
  </div>
   
  <div style="text-align: center; margin: 20px;">
    <form action="downloaddd_report.php" method="post">
        <button type="submit" style="
            background: linear-gradient(to right, #00c853, #00e676);
            color: white;
            padding: 12px 24px;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 230, 118, 0.4);
            transition: background 0.3s ease;
        ">Download Ratings Report</button>
    </form>
</div>

  <!-- Script -->
  <script src="script.js"></script>
  
</body>
</html>
