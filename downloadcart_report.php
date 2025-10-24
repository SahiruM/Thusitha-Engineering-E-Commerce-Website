<?php
require_once('tcpdf/tcpdf.php');
require "connection.php";
session_start();

$userid = $_SESSION["user2"]["id"];

// Fetch cart items
$cartRs = Database::search("
    SELECT product.product_name, product.price, cart_item.quantity
    FROM cart
    INNER JOIN cart_item ON cart.cart_id = cart_item.cart_cart_id
    INNER JOIN product ON product.product_id = cart_item.product_product_id
    WHERE cart.user_id = '".$userid."'
    ORDER BY product.price ASC
");

// Collect data
$productData = [];
$cartItems = [];
while ($row = $cartRs->fetch_assoc()) {
    $name = $row['product_name'];
    $qty = $row['quantity'];
    $price = $row['price'];
    $total = $qty * $price;

    $cartItems[] = $row;
    $productData[$name] = $total;
}

// Initialize TCPDF
$pdf = new TCPDF();
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 12);

// Title
$pdf->Cell(0, 10, 'Cart Report (Price Low to High)', 0, 1, 'C');
$pdf->Ln(5);

// Table
$html = '
<table border="1" cellpadding="5">
<thead>
    <tr style="background-color:#ff9800; color:white;">
        <th><b>Product Name</b></th>
        <th><b>Price</b></th>
        <th><b>Quantity</b></th>
    </tr>
</thead>
<tbody>';
foreach ($cartItems as $row) {
    $html .= '<tr>
        <td>' . htmlspecialchars($row['product_name']) . '</td>
        <td>$' . number_format($row['price'], 2) . '</td>
        <td>' . intval($row['quantity']) . '</td>
    </tr>';
}
$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(10);

// Pie Chart Section
$pdf->SetFont('dejavusans', '', 10);
$pdf->Cell(0, 10, 'Product Value Distribution (Pie Chart)', 0, 1, 'C');

// Calculate total value
$totalValue = array_sum($productData);
if ($totalValue == 0) {
    $pdf->Cell(0, 10, 'No chart data available.', 0, 1, 'C');
    $pdf->Output();
    exit;
}

// Set up drawing
$radius = 30;
$centerX = 105;
$centerY = $pdf->GetY() + $radius + 10;
$startAngle = 0;

$colors = [
    [255, 99, 132], [54, 162, 235], [255, 206, 86],
    [75, 192, 192], [153, 102, 255], [255, 159, 64]
];

$i = 0;
foreach ($productData as $name => $value) {
    $angle = ($value / $totalValue) * 360;
    $color = $colors[$i % count($colors)];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->PieSector($centerX, $centerY, $radius, $startAngle, $startAngle + $angle, 'FD');
    $startAngle += $angle;
    $i++;
}

// Draw legend
$pdf->Ln(2 * $radius + 10);
$pdf->Cell(0, 10, 'Legend:', 0, 1);
$i = 0;
foreach ($productData as $name => $value) {
    $color = $colors[$i % count($colors)];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->Rect(15, $pdf->GetY(), 5, 5, 'F');
    $pdf->SetXY(22, $pdf->GetY());
    $pdf->Cell(0, 5, "$name ($" . number_format($value, 2) . ")", 0, 1);
    $i++;
}

$pdf->Output('cart_report_' . date('Y-m-d_H-i-s') . '.pdf', 'D');
exit;
?>
