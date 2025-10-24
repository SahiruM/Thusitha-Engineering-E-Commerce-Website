<?php
require_once('tcpdf/tcpdf.php');
require 'connection.php';

// Fetch comments
$commentsRs = Database::search("SELECT * FROM `comments` ORDER BY LENGTH(`msg`) ASC");
$comments = [];

$short = 0;
$medium = 0;
$long = 0;

while ($row = $commentsRs->fetch_assoc()) {
    $msg = $row["msg"];
    $comments[] = $msg;

    $length = strlen($msg);
    if ($length < 50) {
        $short++;
    } elseif ($length < 150) {
        $medium++;
    } else {
        $long++;
    }
}

// Prepare pie data
$pieData = [
    "Short (<50 chars)" => $short,
    "Medium (50–149 chars)" => $medium,
    "Long (150+ chars)" => $long
];

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Thusitha Engineering');
$pdf->SetTitle('User Comments Report');
$pdf->SetSubject('Report of User Comments');
$pdf->SetKeywords('TCPDF, PDF, comments, Thusitha Engineering');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Title
$pdf->Cell(0, 10, 'Thusitha Engineering - User Comments Report', 0, 1, 'C');
$pdf->Ln(5);

// Comments list
foreach ($comments as $index => $comment) {
    $pdf->MultiCell(0, 10, ($index + 1) . ". " . $comment, 0, 'L', 0, 1, '', '', true);
}

$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Comment Length Analysis (Pie Chart)', 0, 1, 'C');

// Pie chart drawing
$colors = [[255, 99, 132], [54, 162, 235], [255, 206, 86]];
$centerX = 100;
$centerY = $pdf->GetY() + 35;
$radius = 30;
$startAngle = 0;
$total = array_sum($pieData);
$i = 0;

foreach ($pieData as $label => $count) {
    if ($count == 0) continue; // skip empty slices
    $angle = ($count / $total) * 360;
    $color = $colors[$i % count($colors)];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->PieSector($centerX, $centerY, $radius, $startAngle, $startAngle + $angle, 'FD', false, 0);
    $startAngle += $angle;
    $i++;
}

// Legend
$pdf->Ln(2 * $radius + 10);
$pdf->Cell(0, 10, 'Legend:', 0, 1);
$i = 0;
foreach ($pieData as $label => $count) {
    $color = $colors[$i % count($colors)];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->Rect(15, $pdf->GetY(), 5, 5, 'F');
    $pdf->SetXY(22, $pdf->GetY());
    $pdf->Cell(0, 5, $label . " - " . $count . " comment(s)", 0, 1);
    $i++;
}

// Output
$pdf->Output('user_comments_report.pdf', 'D');
exit;
?>
