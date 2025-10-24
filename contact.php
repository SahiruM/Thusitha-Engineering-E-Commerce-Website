<?php 
require "connection.php";
session_start();
$userid=$_SESSION["user2"]["id"];
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
                        <a href="https://wa.me/94742925420" target="_blank" class="social-link">
                            <span class="icon"><i class="fab fa-whatsapp"></i></span>
                        </a>
                        <a href="https://web.facebook.com/people/Thusitha-Engineering/61550271124318/?_rdc=1&_rdr" target="_blank" class="social-link">
                            <span class="icon"><i class="fab fa-facebook-f"></i></span>
                        </a>
                        <a href="https://www.instagram.com/ThusithaEngineering" target="_blank" class="social-link">
                            <span class="icon"><i class="fab fa-instagram"></i></span>
                        </a>
                        <a href="https://maps.app.goo.gl/A1Hg9T7DrBkw153X9" target="_blank" class="social-link">
                            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                        </a>
                        <a href="https://www.linkedin.com/company/thusitha-engineering" target="_blank" class="social-link">
                            <span class="icon"><i class="fab fa-linkedin-in"></i></span>
                        </a>
                        <a href="https://www.youtube.com/channel/ThusithaEngineering" target="_blank" class="social-link">
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
            <div class="comment-input-container">
                <textarea id="comment-input" placeholder="Leave a comment..."></textarea>
                <button onclick="saveComment()">Post Comment</button>
            </div>

     

            <ul id="comment-list">
            <?php
                $commentsRs = Database::search("SELECT * FROM `comments` INNER JOIN `user` ON `comments`.`user_id` = `user`.`id` WHERE `comments`.`user_id` = '$userid'");
                while ($comments = $commentsRs->fetch_assoc()) {
                    ?>
                    <li>
                    <input type="text" id="comment<?php echo($comments['comments_id'])?>" value="<?php echo($comments["msg"])?> ">
                        
                        <button onclick="updateComment(<?php echo($comments['comments_id'])?>)">Update</button>
                        <button onclick="deleteComment(<?php echo($comments['comments_id'])?>)">Delete</button>
                    </li>
                    <?php
                }
            ?> 
                    
            </ul>
        </div>

        <div class="social-media">
            <h2>Follow Us</h2>
            <div class="social-icons">
                <a href="https://wa.me/94742925420" target="_blank" class="social-link">
                    <span class="icon"><i class="fab fa-whatsapp"></i></span>
                </a>
                <a href="https://web.facebook.com/people/Thusitha-Engineering/61550271124318/?_rdc=1&_rdr#" target="_blank" class="social-link">
                    <span class="icon"><i class="fab fa-facebook-f"></i></span>
                </a>
                <a href="https://www.instagram.com/ThusithaEngineering" target="_blank" class="social-link">
                    <span class="icon"><i class="fab fa-instagram"></i></span>
                </a>
            </div>
        </div>
                


<div style="text-align: center; margin: 20px;">
    <form action="downloadd_report.php" method="post">
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
        ">Download Report</button>
    </form>
</div>

    
        

    </section>
    <?php include "footer.php"; ?>

    <script src="script1.js"></script>
    <script src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
</html>