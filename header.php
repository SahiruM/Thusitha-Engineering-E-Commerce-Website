<header style="background-color: #FF9400; display: flex; justify-content: space-between; align-items: center; padding: 30px 20px;">
    <div class="logo" style="flex-shrink: 0;">
        <img src="assets\Logo.jpg" alt="Logo" style="height: 70px; width: 70px;">
    </div>
    <nav>
    <!-- home -->
    <ul style="list-style: none; display: flex; gap: 3rem; margin: 0;">
            <li><a href="index.php" class="nav-link" style="text-decoration: none; color: black;">HOME</a></li>
            <li><a href="shop.php" class="nav-link" style="text-decoration: none; color: black;">SHOP</a></li>
            <li><a href="contact.php" class="nav-link" style="text-decoration: none; color: black;">CONTACT</a></li>
            <li><a href="about.php" class="nav-link" style="text-decoration: none; color: black;">ABOUT US</a></li>
        </ul>
    </nav>
    <div class="user-cart" style="flex-shrink: 0; margin-right: 5px; position: relative;">
    <a href="cart.php">
        <img src="assets/cart.png" alt="Cart" style="width: 50px; margin-left: 10px;">
    </a>

    <?php 
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
        $user_email = $user["customer_email"];
        // Fetch user data from the database
        $result = Database::search("SELECT * FROM customer_table WHERE customer_email = '$user_email'");
        $user_data = $result->fetch_assoc();

        // Check if user data exists
        if ($user_data) {
            // Fetch profile picture path from database
            $profile_pic = $user_data['customer_pp'] ?? 'https://img.icons8.com/?size=100&id=7819&format=png&color=000000'; // Fallback if no profile picture
        }
    } else {
        $profile_pic = 'https://img.icons8.com/?size=100&id=7819&format=png&color=000000';
    }

    ?>
    <!-- Profile Picture with Dropdown -->
    <div style="display: inline-block; position: relative;">
    <img src="<?php echo $profile_pic; ?>" 
         onclick="toggleDropdown()" 
         style="width: 47px; height: 47px; margin-left: 10px; border-radius: 50%; cursor: pointer; margin-bottom: 2px;" 
         alt="Profile Picture">

        <!-- Dropdown Menu -->
        <div id="dropdownMenu" style="display: none; position: absolute; right: 0; top: 60px; background-color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; z-index: 1000;">
            <?php if (isset($_SESSION["user"])): ?>
                <a href="profile.php" style="display: block; padding: 10px 20px; text-decoration: none; color: black;">View Profile</a>
                <a href="wishlist.php" style="display: block; padding: 10px 20px; text-decoration: none; color: black;">My Wishlist</a>
                <a href="logout.php" style="display: block; padding: 10px 20px; text-decoration: none; color: black;">Logout</a>
            <?php else: ?>
                <a href="login.php" style="display: block; padding: 10px 20px; text-decoration: none; color: black;">Login</a>
            <?php endif; ?>
        </div>
    </div>
    </header>
