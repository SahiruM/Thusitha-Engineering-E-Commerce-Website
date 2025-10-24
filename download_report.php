<?php
require_once('tcpdf/tcpdf.php');
require "connection.php";

// Fetch product ratings
$product_rs = Database::search("
    SELECT p.product_id, p.product_name, FLOOR(AVG(r.review_value)) AS avg_rating
    FROM product p
    LEFT JOIN reviews r ON p.product_id = r.product_product_id
    GROUP BY p.product_id
    ORDER BY avg_rating DESC
");

// Process data
$product_data = [];
$total_rating = 0;
$rating_count = 0;
$no_rating_count = 0;

while ($row = $product_rs->fetch_assoc()) {
    $product_data[] = $row;
    if (!is_null($row['avg_rating'])) {
        $total_rating += $row['avg_rating'];
        $rating_count++;
    } else {
        $no_rating_count++;
    }
}

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator('Tool Store');
$pdf->SetAuthor('Tool Store Admin');
$pdf->SetTitle('Product Ratings Report');
$pdf->SetSubject('Product Ratings');
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 12);

// Report Title
$pdf->Cell(0, 10, 'Product Ratings Report', 0, 1, 'C');
$pdf->Ln(10);

// Table Header
$pdf->SetFillColor(255, 165, 0);
$pdf->SetDrawColor(128, 0, 0);
$pdf->SetFont('', 'B');
$pdf->Cell(30, 10, 'Product ID', 1, 0, 'C', 1);
$pdf->Cell(100, 10, 'Product Name', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Avg Rating', 1, 1, 'C', 1);

// Table Rows
$pdf->SetFont('', '');
$pdf->SetFillColor(224, 235, 255);
$fill = 0;

foreach ($product_data as $row) {
    $pdf->Cell(30, 8, $row['product_id'], 1, 0, 'C', $fill);
    $pdf->Cell(100, 8, $row['product_name'], 1, 0, 'L', $fill);
    $pdf->Cell(30, 8, ($row['avg_rating'] ?? 'No Ratings'), 1, 1, 'C', $fill);
    $fill = !$fill;
}

// Analysis
$pdf->Ln(10);
$pdf->SetFont('', 'B', 12);
$pdf->Cell(0, 10, 'Analysis Summary', 0, 1, 'L');
$pdf->SetFont('', '', 11);

$highest = $product_data[0] ?? null;
$lowest = null;
foreach (array_reverse($product_data) as $row) {
    if (!is_null($row['avg_rating'])) {
        $lowest = $row;
        break;
    }
}
$average_rating = $rating_count > 0 ? round($total_rating / $rating_count, 2) : 'N/A';

$pdf->MultiCell(0, 8, "Total Products Rated: $rating_count", 0, 'L');
$pdf->MultiCell(0, 8, "Products with No Ratings: $no_rating_count", 0, 'L');
$pdf->MultiCell(0, 8, "Average Rating Across All Products: $average_rating", 0, 'L');
if ($highest) {
    $pdf->MultiCell(0, 8, "Highest Rated: {$highest['product_name']} ({$highest['avg_rating']})", 0, 'L');
}
if ($lowest) {
    $pdf->MultiCell(0, 8, "Lowest Rated: {$lowest['product_name']} ({$lowest['avg_rating']})", 0, 'L');
}

// Pie Chart (TCPDF Only)
$pdf->Ln(10);
$pdf->SetFont('', 'B', 12);
$pdf->Cell(0, 10, 'Pie Chart: Rating Distribution', 0, 1, 'L');

$pdf->SetFont('', '', 10);
$pdf->Ln(2);

// Pie Chart Data
$pie_data = [];
foreach ($product_data as $row) {
    if (!is_null($row['avg_rating']) && $row['avg_rating'] > 0) {
        $pie_data[] = [
            'label' => $row['product_name'],
            'value' => $row['avg_rating']
        ];
    }
}

$total = array_sum(array_column($pie_data, 'value'));
$centerX = 105;
$centerY = $pdf->GetY() + 60;
$radius = 40;
$start_angle = 0;
$colors = [[255, 99, 132], [54, 162, 235], [255, 206, 86], [75, 192, 192], [153, 102, 255], [255, 159, 64], [100, 200, 100], [200, 50, 100], [100, 50, 200], [50, 150, 50]];

$i = 0;
foreach ($pie_data as $entry) {
    $angle = ($entry['value'] / $total) * 360;
    $color = $colors[$i % count($colors)];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->PieSector($centerX, $centerY, $radius, $start_angle, $start_angle + $angle, 'FD', false, 0);
    $start_angle += $angle;
    $i++;
}

// Pie Chart Legend
$pdf->Ln(95);
$pdf->SetFont('', '', 9);
$i = 0;
foreach ($pie_data as $entry) {
    $color = $colors[$i % count($colors)];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->Cell(5, 5, '', 0, 0, '', 1);
    $pdf->Cell(0, 5, ' ' . $entry['label'] . ' (' . $entry['value'] . ')', 0, 1);
    $i++;
}

// Output PDF
$pdf->Output('product_ratings_report.pdf', 'D');
?>
