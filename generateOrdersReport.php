<?php
require_once('tcpdf/tcpdf.php');
require "connection.php";

// Initialize TCPDF
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Title
$pdf->Cell(0, 10, 'Placed Orders Report', 0, 1, 'C');
$pdf->Ln(5);

// Fetch orders from DB
$orders = Database::search("SELECT * FROM `checkout` ORDER BY `payment_method`, `id` ASC");

// Separate orders
$cashOrders = [];
$bankOrders = [];

while ($order = $orders->fetch_assoc()) {
    if (strtolower($order['payment_method']) === 'cash_on_delivery') {
        $cashOrders[] = $order;
    } elseif (strtolower($order['payment_method']) === 'bank_payment') {
        $bankOrders[] = $order;
    }
}

// Debug Info
$pdf->SetFont('helvetica', 'I', 10);
$pdf->Cell(0, 10, 'DEBUG: Total Orders Fetched = ' . ($orders->num_rows ?? 0), 0, 1, 'L');
$pdf->Ln(3);

// Function to render a table
function renderTable($pdf, $orders, $title) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, $title, 0, 1, 'L');

    // Table header
    $pdf->Cell(30, 10, 'Order ID', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Name', 1, 0, 'C');
    $pdf->Cell(70, 10, 'Address', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Email', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Phone', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Payment', 1, 1, 'C');

    $pdf->SetFont('helvetica', '', 12);
    if (count($orders) > 0) {
        foreach ($orders as $order) {
            $pdf->Cell(30, 10, $order['id'], 1, 0, 'C');
            $pdf->Cell(50, 10, $order['name'], 1, 0, 'C');
            $pdf->Cell(70, 10, $order['shipping_address'], 1, 0, 'C');
            $pdf->Cell(50, 10, $order['email'], 1, 0, 'C');
            $pdf->Cell(30, 10, $order['phone'], 1, 0, 'C');
            $pdf->Cell(40, 10, $order['payment_method'], 1, 1, 'C');
        }
    } else {
        $pdf->Cell(270, 10, 'No orders found.', 1, 1, 'C');
    }

    $pdf->Ln(5);
}

// Render each payment type
renderTable($pdf, $cashOrders, 'Cash on Delivery Orders');
renderTable($pdf, $bankOrders, 'Bank Payment Orders');

// -----------------------------
// Analytical Section + Chart
// -----------------------------
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Order Analysis', 0, 1, 'L');
$pdf->Ln(5);

// Count values
$totalOrders = count($cashOrders) + count($bankOrders);
$cashCount = count($cashOrders);
$bankCount = count($bankOrders);

$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, "Total Orders: $totalOrders", 0, 1, 'L');
$pdf->Cell(0, 10, "Cash Orders: $cashCount", 0, 1, 'L');
$pdf->Cell(0, 10, "Bank Orders: $bankCount", 0, 1, 'L');
$pdf->Ln(10);

// If no data, skip the chart
if ($totalOrders == 0) {
    $pdf->SetFont('helvetica', 'I', 12);
    $pdf->Cell(0, 10, 'No data available to display chart.', 0, 1, 'L');
} else {
    // Chart Title
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Order Method Comparison', 0, 1, 'C');

    // Coordinates
    $chartX = 60;
    $chartY = $pdf->GetY() + 50;
    $barWidth = 40;
    $scaleFactor = 6; // Adjust based on spacing

    // Axes
    $pdf->Line($chartX - 10, $chartY, $chartX - 10, $chartY - 100); // Y-axis
    $pdf->Line($chartX - 10, $chartY, $chartX + 2 * ($barWidth + 50), $chartY); // X-axis

    // Bar Heights
    $cashBarHeight = $cashCount * $scaleFactor;
    $bankBarHeight = $bankCount * $scaleFactor;

    // Cash Bar
    $pdf->SetFillColor(0, 102, 204);
    $pdf->Rect($chartX, $chartY - $cashBarHeight, $barWidth, $cashBarHeight, 'F');
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Text($chartX + 10, $chartY + 5, 'Cash');
    $pdf->Text($chartX + 10, $chartY - $cashBarHeight - 8, "$cashCount");

    // Bank Bar
    $pdf->SetFillColor(0, 204, 102);
    $pdf->Rect($chartX + $barWidth + 60, $chartY - $bankBarHeight, $barWidth, $bankBarHeight, 'F');
    $pdf->Text($chartX + $barWidth + 70, $chartY + 5, 'Bank');
    $pdf->Text($chartX + $barWidth + 70, $chartY - $bankBarHeight - 8, "$bankCount");
}

// Output
$pdf->Output('placed_orders_report.pdf', 'D');
?>
