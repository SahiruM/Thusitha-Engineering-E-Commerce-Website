<?php 
require "connection.php";
session_start();
$userid = isset($_SESSION["user2"]["id"]) ? (int)$_SESSION["user2"]["id"] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thusitha Engineering | Contact Us</title>
    <link rel="stylesheet" href="styles1.css">
    <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="header.css" />
    <link rel="stylesheet" href="footer.css">

</head>


<body>

<?php include "header.php"; ?>
    <section class="hero"></section>

    <section class="contact">
        <div class="contact-description">
            <h2>Contact Us</h2>
        </div>

        <div class="inquiry-form">
            <div class="contact-info">
                <h3>Location:</h3>
                <p>Batapola, Galle Road.</p>
                <p class="map-link">
                    <a href="https://maps.app.goo.gl/A1Hg9T7DrBkw153X9" target="_blank" class="google-map-link">
                        <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                        View on Google Maps
                    </a>
                </p>
                <h3>
                    <span class="support-icon"><i class="fas fa-users"></i></span>
                    Our Support Team:
                </h3>
                <div class="support-icons-container">
                    <div class="support-icons">
                        <a href="https://wa.me/94742925420" target="_blank" class="social-link" aria-label="WhatsApp">
                            <span class="icon"><i class="fab fa-whatsapp"></i></span>
                        </a>
                        <a href="https://web.facebook.com/people/Thusitha-Engineering/61550271124318/?_rdc=1&_rdr" target="_blank" class="social-link" aria-label="Facebook">
                            <span class="icon"><i class="fab fa-facebook-f"></i></span>
                        </a>
                        <a href="https://www.instagram.com/ThusithaEngineering" target="_blank" class="social-link" aria-label="Instagram">
                            <span class="icon"><i class="fab fa-instagram"></i></span>
                        </a>
                        <a href="https://maps.app.goo.gl/A1Hg9T7DrBkw153X9" target="_blank" class="social-link" aria-label="Google Maps">
                            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                        </a>
                        <a href="https://www.linkedin.com/company/thusitha-engineering" target="_blank" class="social-link" aria-label="LinkedIn">
                            <span class="icon"><i class="fab fa-linkedin-in"></i></span>
                        </a>
                        <a href="https://www.youtube.com/channel/ThusithaEngineering" target="_blank" class="social-link" aria-label="YouTube">
                            <span class="icon"><i class="fab fa-youtube"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <form onsubmit="return false;" >
                <input type="text" id="name" placeholder="Your Name" required>
                <input type="email" id="email" placeholder="Your Email" required>
                <input type="tel" id="phone" placeholder="Your Phone" required>
                <textarea id="message" placeholder="Your Comment" required></textarea>
                <button onclick="save_message()">Submit</button>

                <p id="form-message"></p>
            </form>
        </div>

        <p id="form-message"></p>


        <div class="comments">
            <h2>Comments</h2>
            <?php if ($userid): ?>
                <div class="comment-input-container">
                    <textarea id="comment-input" placeholder="Leave a comment..."></textarea>
                    <button onclick="saveComment()">Post Comment</button>
                </div>
            <?php else: ?>
                <p>Please <a href="login.php">log in</a> to leave and manage comments.</p>
            <?php endif; ?>

     

            <ul id="comment-list">
            <?php
                if ($userid) {
                    $commentsRs = Database::select(
                        "SELECT * FROM `comments` INNER JOIN `user` ON `comments`.`user_id` = `user`.`id` WHERE `comments`.`user_id` = ?",
                        "i",
                        $userid
                    );
                    while ($comments = $commentsRs->fetch_assoc()) {
                    ?>
                    <li>
                    <input type="text" id="comment<?php echo (int)$comments['comments_id']; ?>" value="<?php echo htmlspecialchars($comments["msg"]); ?>">
                        
                        <button onclick="updateComment(<?php echo (int)$comments['comments_id']; ?>)">Update</button>
                        <button onclick="deleteComment(<?php echo (int)$comments['comments_id']; ?>)">Delete</button>
                    </li>
                    <?php
                    }
                }
            ?> 
                    
            </ul>
        </div>

        <div class="social-media">
            <h2>Follow Us</h2>
            <div class="social-icons">
                <a href="https://wa.me/94742925420" target="_blank" class="social-link" aria-label="WhatsApp">
                    <span class="icon"><i class="fab fa-whatsapp"></i></span>
                </a>
                <a href="https://web.facebook.com/people/Thusitha-Engineering/61550271124318/?_rdc=1&_rdr#" target="_blank" class="social-link" aria-label="Facebook">
                    <span class="icon"><i class="fab fa-facebook-f"></i></span>
                </a>
                <a href="https://www.instagram.com/ThusithaEngineering" target="_blank" class="social-link" aria-label="Instagram">
                    <span class="icon"><i class="fab fa-instagram"></i></span>
                </a>
            </div>
        </div>
                


<div class="report-panel">
    <form action="downloadd_report.php" method="post">
        <button type="submit">Download Report</button>
    </form>
</div>

    
        

    </section>
    <?php include "footer.php"; ?>

    <script src="script1.js"></script>
    <script src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
</html>
