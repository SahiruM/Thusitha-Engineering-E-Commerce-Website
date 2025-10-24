<?php
require_once('tcpdf/tcpdf.php');
require 'connection.php';

// Fetch products
$productRs = Database::search("SELECT * FROM `product` ORDER BY `stock` ASC");
$products = [];

$inStock = 0;
$outStock = 0;

while ($row = $productRs->fetch_assoc()) {
    $products[] = $row;
    if ($row['stock'] > 0) {
        $inStock++;
    } else {
        $outStock++;
    }
}

// Prepare pie chart data
$stockData = [
    "In Stock" => $inStock,
    "Out of Stock" => $outStock
];

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ToolStore');
$pdf->SetTitle('Product Stock Report');
$pdf->SetSubject('Stock Availability');
$pdf->SetKeywords('TCPDF, PDF, report, stock');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Title
$pdf->Cell(0, 10, 'ToolStore - Product Stock Report', 0, 1, 'C');
$pdf->Ln(5);

// --- Out of Stock Section ---
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Out of Stock Products', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(5);

$hasOutOfStock = false;
foreach ($products as $product) {
    if ($product['stock'] == 0) {
        $hasOutOfStock = true;
        $pdf->MultiCell(0, 10,
            "Product: " . $product["product_name"] . "\n" .
            "Price: Rs." . $product["price"] . ".00\n\n",
        0, 'L', 0, 1);
    }
}
if (!$hasOutOfStock) {
    $pdf->MultiCell(0, 10, "No Out of Stock products found.\n\n", 0, 'L', 0, 1);
}

$pdf->Ln(5);

// --- In Stock Section ---
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'In Stock Products', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(5);

$hasInStock = false;
foreach ($products as $product) {
    if ($product['stock'] > 0) {
        $hasInStock = true;
        $pdf->MultiCell(0, 10,
            "Product: " . $product["product_name"] . "\n" .
            "Price: Rs." . $product["price"] . ".00\n" .
            "Stock: " . $product["stock"] . "\n\n",
        0, 'L', 0, 1);
    }
}
if (!$hasInStock) {
    $pdf->MultiCell(0, 10, "No In Stock products found.\n\n", 0, 'L', 0, 1);
}

$pdf->Ln(5);

// --- Pie Chart Section ---
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Stock Overview (Pie Chart)', 0, 1, 'C');
$pdf->Ln(5);

$colors = [[76, 175, 80], [244, 67, 54]]; // green (in stock), red (out of stock)
$centerX = 100;
$centerY = $pdf->GetY() + 30;
$radius = 30;
$startAngle = 0;
$total = array_sum($stockData);
$i = 0;

foreach ($stockData as $label => $count) {
    if ($count == 0) continue;
    $angle = ($count / $total) * 360;
    $color = $colors[$i % count($colors)];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->PieSector($centerX, $centerY, $radius, $startAngle, $startAngle + $angle, 'FD', false, 0);
    $startAngle += $angle;
    $i++;
}

// Legend
$pdf->Ln(2 * $radius + 10);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Legend:', 0, 1);
$i = 0;
foreach ($stockData as $label => $count) {
    $color = $colors[$i % count($colors)];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->Rect(15, $pdf->GetY(), 5, 5, 'F');
    $pdf->SetXY(22, $pdf->GetY());
    $pdf->Cell(0, 5, $label . " - " . $count . " product(s)", 0, 1);
    $i++;
}

// Output
$pdf->Output('product_stock_report.pdf', 'D');
exit;
?>
