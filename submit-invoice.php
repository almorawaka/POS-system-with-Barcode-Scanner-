<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

// Generate Invoice Number
$invoiceNumber = "INV" . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

// Save invoice
$stmt = $conn->prepare("INSERT INTO invoices (invoice_number, customer_name, customer_address, customer_phone, total_amount) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssd", $invoiceNumber, $data['name'], $data['address'], $data['phone'], $data['total']);
$stmt->execute();
$invoice_id = $conn->insert_id;

// Save items and reduce stock
foreach ($data['items'] as $item) {
    // Insert invoice item
    $stmt = $conn->prepare("INSERT INTO invoice_items (invoice_id, item_code, item_name, price, qty, total) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdii", $invoice_id, $item['item_code'], $item['name'], $item['selling_price'], $item['qty'], $item['total']);
    $stmt->execute();

    // Reduce quantity from items table
    $qty = (int)$item['qty'];
    $item_code = $conn->real_escape_string($item['item_code']);
    $conn->query("UPDATE items SET quantity = quantity - {$qty} WHERE item_code = '{$item_code}'");
}

// Return invoice number to open PDF preview
echo json_encode(['invoice_number' => $invoiceNumber]);
?>
