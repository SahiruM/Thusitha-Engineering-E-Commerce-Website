<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: adminLogin.php");
    exit();
}

require "connection.php";

$totalUsersData = Database::search("SELECT COUNT(*) AS total_users FROM `user`")->fetch_assoc();
$totalproductsData = Database::search("SELECT COUNT(*) AS total_products FROM `product`")->fetch_assoc();
$totalCommentsData = Database::search("SELECT COUNT(*) AS total_comments FROM `comments`")->fetch_assoc();
$totalOrdersData = Database::search("SELECT COUNT(*) AS total_orders FROM `checkout`")->fetch_assoc();
$totalMessagesData = Database::search("SELECT COUNT(*) AS total_messages FROM `message`")->fetch_assoc();
$mostLoggedInData = Database::search("SELECT customer_email, login_count FROM `customer_table` ORDER BY login_count DESC LIMIT 1")->fetch_assoc();
$totalLoginCountData = Database::search("SELECT SUM(login_count) AS total_login_count FROM `customer_table`")->fetch_assoc();


$productNames = [];

$stockDataQuery = Database::search("SELECT product_name, img, stock FROM product LIMIT 10");
while ($row = $stockDataQuery->fetch_assoc()) {
    $productNames[] = $row['product_name'];  // Store product names
    $productStocks[] = $row['stock'];
}


$paymentDataQuery = Database::search("SELECT payment_method, COUNT(*) AS count FROM checkout GROUP BY payment_method");
$paymentLabels = [];
$paymentCounts = [];

while ($row = $paymentDataQuery->fetch_assoc()) {
    $paymentLabels[] = $row["payment_method"];
    $paymentCounts[] = $row["count"];
}


$ratingQuery = Database::search("
    SELECT p.product_name, AVG(r.review_value) AS avg_rating
    FROM reviews r
    INNER JOIN product p ON r.product_product_id = p.product_id
    GROUP BY r.product_product_id
    ORDER BY avg_rating DESC
    LIMIT 10
");

$ratingLabels = [];
$ratingValues = [];

while ($row = $ratingQuery->fetch_assoc()) {
    $ratingLabels[] = $row["product_name"];
    $ratingValues[] = round($row["avg_rating"], 2); // Round to 2 decimals
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cool Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Bayon&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="manageUsersStyles.css">
    <link rel="stylesheet" href="adminHeader.css">
    <style>


    body {
        margin: 0;
        font-family: 'Bayon', sans-serif;
        background: #000;
        color: #fff;
    }

    h1 {
        text-align: center;
        padding: 30px 0;
        font-size: 50px;
        background: #000;
        margin: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        color: #FF9400;
        font-weight: normal;

    }

    .dashboard {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 40px 20px;
    }

    .info-box {
        position: relative;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 25px;
        width: 480px;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }

    .info-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(255, 148, 0, 0.25);
    }

    .info-box h2 {
        font-size: 1.5em;
        margin-bottom: 12px;
        color: #FF9400;
        font-weight: normal;
        letter-spacing: 1px;
    }

    .info-box p {
        font-size: 1.9em;
        font-weight: normal;
        color: #ffffff;
    }

    .chart-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 40px;
        padding: 20px 0 60px;
    }

    .chart {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 10px;
        width: 500px;
        height: 550px;
        color: #fff;
        border: 1px solid rgba(255, 148, 0, 0.2);
    }

    .chart h3 {
        text-align: center;
        margin-top: 0px;
        color: #FF9400;
        font-weight: normal;
        font-size:30px;
    }

    canvas {
        width: 500px !important;
        height: 450px !important;
    }
</style>
</head>
<body>
<?php 
    include "adminHeader.php";
    ?>
    <h1>ToolStore Admin Dashboard</h1>



    <div class="chart-container">
        <div class="chart">
            <h3>Stock Per Product</h3>
            <canvas id="totalProductsChart"></canvas>
        </div>
        <div class="chart">
            <h3>Orders by Payment Method</h3>
            <canvas id="paymentMethodChart"></canvas>
        </div>
        <div class="chart">
            <h3>Average Product Ratings</h3>
            <canvas id="ratingChart"></canvas>
        </div>


    </div>

    <div class="dashboard">
    <div class="info-box"><h2>Total Users</h2><p class="count-up" data-count="<?= $totalUsersData['total_users']; ?>">0</p></div>
    <div class="info-box"><h2>Total Products</h2><p class="count-up" data-count="<?= $totalproductsData['total_products']; ?>">0</p></div>
    <div class="info-box"><h2>Total Comments</h2><p class="count-up" data-count="<?= $totalCommentsData['total_comments']; ?>">0</p></div>
    <div class="info-box"><h2>Total Orders</h2><p class="count-up" data-count="<?= $totalOrdersData['total_orders']; ?>">0</p></div>
    <div class="info-box"><h2>Total Messages</h2><p class="count-up" data-count="<?= $totalMessagesData['total_messages']; ?>">0</p></div>
    <div class="info-box"><h2>Total Login Count</h2><p class="count-up" data-count="<?= $totalLoginCountData['total_login_count']; ?>">0</p></div>
</div>


   
    <script>
        const productNames = <?php echo json_encode($productNames); ?>;
        const productStocks = <?php echo json_encode($productStocks); ?>;

        const totalProductsChart = new Chart(document.getElementById('totalProductsChart'), {
    type: 'bar',
    data: {
        labels: productNames,  // Display product names as labels
        datasets: [{
            label: 'Stock Count',
            data: productStocks,
            backgroundColor: '#4caf50',
            borderColor: '#388e3c',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 5000,
            easing: 'easeOutQuart'
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Stock Count'
                }
            },
            x: {
                ticks: {
                    minRotation: 90,
                    font: {
                    size: 20 // or any size you prefer
        },
                    color: '#fff'
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});



const paymentLabels = <?php echo json_encode($paymentLabels); ?>;
const paymentCounts = <?php echo json_encode($paymentCounts); ?>;

const paymentMethodChart = new Chart(document.getElementById('paymentMethodChart'), {
    type: 'pie',
    data: {
        labels: paymentLabels,
        datasets: [{
            data: paymentCounts,
            backgroundColor: ['#ff9800', '#03a9f4'],
            borderColor: '#141422',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        animation: {
            duration: 5000,
            easing: 'easeOutQuart'
        },
        plugins: {
            legend: {
                labels: {
                    color: '#fff',
                    font: {
                        size: 14
                    }
                }
            },
        }
    }
});



const ratingLabels = <?php echo json_encode($ratingLabels); ?>;
const ratingValues = <?php echo json_encode($ratingValues); ?>;

const ratingChart = new Chart(document.getElementById('ratingChart'), {
    type: 'bar',
    data: {
        labels: ratingLabels,
        datasets: [{
            label: 'Average Rating',
            data: ratingValues,
            backgroundColor: '#ff6384',
            borderColor: '#c2185b',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 5000,
            easing: 'easeOutQuart'
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 5,
                title: {
                    display: true,
                    text: 'Rating (out of 5)'
                }
            },
            x: {
                ticks: {
                    minRotation: 90,
                    font: {
                        size: 18
                    },
                    color: '#fff'
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});



    // Count up animation
    document.querySelectorAll('.count-up').forEach((el) => {
        let target = +el.getAttribute('data-count');
        let duration = 2000; // total animation duration in ms
        let start = 0;
        let startTime = null;

        function updateNumber(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = timestamp - startTime;
            const current = Math.min(Math.floor((progress / duration) * target), target);
            el.textContent = current;

            if (current < target) {
                requestAnimationFrame(updateNumber);
            }
        }

        requestAnimationFrame(updateNumber);
    });





    </script>
</body>
</html>
