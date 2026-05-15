<header class="site-header">
    <a class="site-logo" href="index.php" aria-label="Thusitha Engineering home">
        <img src="assets/Logo.jpg" alt="Thusitha Engineering logo">
    </a>

    <nav class="site-nav" aria-label="Primary navigation">
        <ul>
            <li><a href="index.php" class="nav-link">Home</a></li>
            <li><a href="shop.php" class="nav-link">Shop</a></li>
            <li><a href="contact.php" class="nav-link">Contact</a></li>
            <li><a href="about.php" class="nav-link">About Us</a></li>
        </ul>
    </nav>

    <div class="header-actions">
        <a class="cart-link" href="cart.php" aria-label="View cart">
            <img src="assets/cart.png" alt="">
        </a>

        <?php
        $profile_pic = 'https://img.icons8.com/?size=100&id=7819&format=png&color=000000';

        if (isset($_SESSION["user"])) {
            $user = $_SESSION["user"];
            $user_email = $user["customer_email"];
            $result = Database::search("SELECT * FROM customer_table WHERE customer_email = '$user_email'");
            $user_data = $result->fetch_assoc();

            if ($user_data && !empty($user_data['customer_pp'])) {
                $profile_pic = $user_data['customer_pp'];
            }
        }
        ?>

        <div class="profile-menu">
            <button class="profile-button" type="button" onclick="toggleDropdown()" aria-label="Open account menu">
                <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile picture">
            </button>

            <div id="dropdownMenu" class="dropdown-menu">
                <?php if (isset($_SESSION["user"])): ?>
                    <a href="profile.php">View Profile</a>
                    <a href="wishlist.php">My Wishlist</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
