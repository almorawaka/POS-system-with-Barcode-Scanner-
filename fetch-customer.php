<?php
include 'db.php';

$phone = $_GET['phone'];

$stmt = $conn->prepare("SELECT * FROM customers WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Customer not found']);
}
?>
