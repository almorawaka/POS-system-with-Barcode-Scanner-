<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("Invoice ID not provided.");
}

$invoice_id = (int)$_GET['id'];
$invoice_result = $conn->query("SELECT * FROM invoices WHERE id = $invoice_id");
$invoice = $invoice_result->fetch_assoc();
$item_result = $conn->query("SELECT * FROM invoice_items WHERE invoice_id = $invoice_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice Items</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Invoice Items for Invoice #<?php echo $invoice['invoice_number']; ?></h2>
    <p><strong>Customer:</strong> <?php echo $invoice['customer_name']; ?> | <strong>Date:</strong> <?php echo $invoice['created_at']; ?></p>
    <table border="1">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $item_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $item['item_code']; ?></td>
                    <td><?php echo $item['item_name']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $item['qty']; ?></td>
                    <td><?php echo $item['total']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
