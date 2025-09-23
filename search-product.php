<?php include 'db.php';

$searchTerm = $_GET['search'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Search Product</h2>

    <form method="GET">
        <input type="text" name="search" placeholder="Search item name or code..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Search</button>
    </form>

    <table border="1" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Name</th>
                <th>Selling Price</th>
                <th>Quantity</th>
                <th>View Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM items";
            if (!empty($searchTerm)) {
                $searchTermSQL = "%" . $conn->real_escape_string($searchTerm) . "%";
                $sql .= " WHERE item_code LIKE '$searchTermSQL' OR name LIKE '$searchTermSQL'";
            }
            $sql .= " ORDER BY id DESC";

            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['item_code']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['selling_price']}</td>
                        <td>{$row['quantity']}</td>
                        <td>";
                if (!empty($row['image'])) {
                    $images = explode(',', $row['image']);
                    foreach ($images as $img) {
                        echo "<a href='{$img}' target='_blank'>View</a> ";
                    }
                } else {
                    echo "No Image";
                }
                echo "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
