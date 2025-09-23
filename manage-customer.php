<?php include 'db.php';

// Add customer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_customer'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO customers (name, address, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $address, $phone);
    $stmt->execute();
    header("Location: manage-customer.php");
    exit;
}

// Delete customer
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM customers WHERE id = $id");
    header("Location: manage-customer.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Manage Customers</h2>

    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Address:</label>
        <input type="text" name="address" required><br>
        <label>Phone No:</label>
        <input type="text" name="phone" required><br>
        <button type="submit" name="add_customer">Add Customer</button>
    </form>

    <h3>Customer List</h3>
    <table border="1">
        <tr><th>Name</th><th>Address</th><th>Phone No</th><th>Action</th></tr>
        <?php
        $result = $conn->query("SELECT * FROM customers ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['phone']}</td>
                    <td><a href='manage-customer.php?delete={$row['id']}' onclick=\"return confirm('Are you sure?');\">Delete</a></td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
