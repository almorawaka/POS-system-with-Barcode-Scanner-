<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>View Invoices by Date</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>View Invoices</h2>

    <form method="GET">
        <label>From Date:</label>
        <input type="date" name="from_date" required value="<?php echo $_GET['from_date'] ?? ''; ?>">
        <label>To Date:</label>
        <input type="date" name="to_date" required value="<?php echo $_GET['to_date'] ?? ''; ?>">
        <button type="submit">Filter</button>
    </form>

    <table border="1" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $from = $_GET['from_date'] ?? null;
            $to = $_GET['to_date'] ?? null;

            if ($from && $to) {
                $stmt = $conn->prepare("SELECT * FROM invoices WHERE DATE(created_at) BETWEEN ? AND ? ORDER BY id DESC");
                $stmt->bind_param("ss", $from, $to);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $conn->query("SELECT * FROM invoices ORDER BY id DESC");
            }

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['invoice_number']}</td>
                        <td>{$row['customer_name']}</td>
                        <td>{$row['customer_phone']}</td>
                        <td>Rs. {$row['total_amount']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='print-invoice.php?invoice={$row['invoice_number']}' target='_blank'>View</a> |
                            <a href='invoice-items.php?id={$row['id']}'>Items</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

