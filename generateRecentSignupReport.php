<?php
require_once('tcpdf/tcpdf.php');
require "connection.php";

// Initialize TCPDF object
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// Add first page
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// ====== Title ======
$pdf->Cell(0, 10, 'Recent User Signups Report', 0, 1, 'C');

// ====== Table Header ======
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(30, 10, 'User ID', 1, 0, 'C');
$pdf->Cell(60, 10, 'Name', 1, 0, 'C');
$pdf->Cell(60, 10, 'Email', 1, 0, 'C');
$pdf->Cell(40, 10, 'Telephone', 1, 0, 'C');
$pdf->Cell(60, 10, 'Registration Date', 1, 1, 'C');

// ====== Table Body ======
$pdf->SetFont('helvetica', '', 12);
$users = Database::search("SELECT * FROM `customer_table` ORDER BY registered_date DESC");
while ($user = $users->fetch_assoc()) {
    $pdf->Cell(30, 10, $user["customer_id"], 1, 0, 'C');
    $pdf->Cell(60, 10, $user["customer_name"], 1, 0, 'C');
    $pdf->Cell(60, 10, $user["customer_email"], 1, 0, 'C');
    $pdf->Cell(40, 10, $user["customer_telephone"], 1, 0, 'C');
    $pdf->Cell(60, 10, $user["registered_date"], 1, 1, 'C');
}

// ====== New Page for Analysis ======
$pdf->AddPage();
$pdf->Ln(10);

// ====== Analytical Summary ======
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Analytical Summary', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// Total number of users
$totalUsersResult = Database::search("SELECT COUNT(*) AS total_users FROM customer_table");
$totalUsersRow = $totalUsersResult->fetch_assoc();
$totalUsers = $totalUsersRow['total_users'] ?? 0;

// Total number of logins
$totalLoginsResult = Database::search("SELECT SUM(login_count) AS total_logins FROM customer_table");
$totalLoginsRow = $totalLoginsResult->fetch_assoc();
$totalLogins = $totalLoginsRow['total_logins'] ?? 0;

// Most active user
$topUserResult = Database::search("SELECT customer_name, login_count FROM customer_table ORDER BY login_count DESC LIMIT 1");
$topUserRow = $topUserResult->fetch_assoc();
$topUserName = $topUserRow['customer_name'] ?? "N/A";
$topUserLogins = $topUserRow['login_count'] ?? 0;

// Output analytical info
$pdf->Cell(0, 10, 'Total Users: ' . $totalUsers, 0, 1, 'L');
$pdf->Cell(0, 10, 'Total Logins: ' . $totalLogins, 0, 1, 'L');
$pdf->Cell(0, 10, 'Most Active User: ' . $topUserName . ' (' . $topUserLogins . ' logins)', 0, 1, 'L');

// ====== Bar Chart: User Login Activity ======
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'User Login Activity Chart (Top 5 Users)', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);

// Fetch top 5 active users
$topUsersResult = Database::search("SELECT customer_name, login_count FROM customer_table ORDER BY login_count DESC LIMIT 5");

// Setup chart variables
$xStart = 30;
$yStart = $pdf->GetY() + 10;
$barWidth = 30;
$maxHeight = 50;

// Get maximum login count for scaling
$maxLoginResult = Database::search("SELECT MAX(login_count) AS max_login FROM customer_table");
$maxLoginRow = $maxLoginResult->fetch_assoc();
$maxLogin = $maxLoginRow['max_login'] ?? 1;

$barX = $xStart;
$colors = [
    [255, 99, 132],   // Red
    [54, 162, 235],   // Blue
    [255, 206, 86],   // Yellow
    [75, 192, 192],   // Teal
    [153, 102, 255]   // Purple
];
$colorIndex = 0;

while ($row = $topUsersResult->fetch_assoc()) {
    $userName = $row['customer_name'];
    $loginCount = $row['login_count'];
    $barHeight = ($loginCount / $maxLogin) * $maxHeight;

    // Set fill color
    $color = $colors[$colorIndex % count($colors)];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);

    // Draw the bar
    $pdf->Rect($barX, $yStart + ($maxHeight - $barHeight), $barWidth, $barHeight, 'F');

    // Draw login count above bar
    $pdf->SetXY($barX, $yStart + ($maxHeight - $barHeight) - 5);
    $pdf->Cell($barWidth, 5, $loginCount, 0, 0, 'C');

    // Draw username below bar
    $pdf->SetXY($barX, $yStart + $maxHeight + 2);
    $pdf->MultiCell($barWidth, 5, $userName, 0, 'C', false);

    $barX += $barWidth + 10;
    $colorIndex++;
}

// ====== Output PDF ======
$pdf->Output('recent_signups_report.pdf', 'D');
?>
