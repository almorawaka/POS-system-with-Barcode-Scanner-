<?php
include 'db.php';

function uploadImages($files) {
    $uploaded = [];
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);

    for ($i = 0; $i < 5; $i++) {
        if (isset($files['name'][$i]) && $files['error'][$i] == 0) {
            $filename = basename($files["name"][$i]);
            $target_file = $target_dir . time() . "_" . $filename;
            if (move_uploaded_file($files["tmp_name"][$i], $target_file)) {
                $uploaded[] = $target_file;
            }
        }
    }
    return implode(",", $uploaded);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $code = $_POST['item_code'];
    $name = $_POST['name'];
    $buying_price = $_POST['buying_price'];
    $selling_price = $_POST['selling_price'];
    $quantity = $_POST['quantity'];
    $images = uploadImages($_FILES['images']);

    // Check if item exists
    $check = $conn->prepare("SELECT id, quantity FROM items WHERE item_code = ?");
    $check->bind_param("s", $code);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Update item
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $stmt = $conn->prepare("UPDATE items SET buying_price=?, selling_price=?, quantity=?, image=? WHERE item_code=?");
        $stmt->bind_param("ddiss", $buying_price, $selling_price, $new_quantity, $images, $code);
    } else {
        // Insert new item
        $stmt = $conn->prepare("INSERT INTO items (item_code, name, buying_price, selling_price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddss", $code, $name, $buying_price, $selling_price, $quantity, $images);
    }

    $stmt->execute();
    header("Location: manage-items.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_item'])) {
    $id = $_POST['id'];
    $code = $_POST['item_code'];
    $name = $_POST['name'];
    $buying_price = $_POST['buying_price'];
    $selling_price = $_POST['selling_price'];
    $quantity = $_POST['quantity'];

    $newImages = uploadImages($_FILES['images']);
    if ($newImages) {
       $stmt = $conn->prepare("UPDATE items SET item_code=?, name=?, buying_price=?, selling_price=?, quantity=?, image=? WHERE id=?");
       $stmt->bind_param("ssddssi", $code, $name, $buying_price, $selling_price, $quantity, $newImages, $id);
    } else {
        $stmt = $conn->prepare("UPDATE items SET item_code=?, name=?, buying_price=?, selling_price=?, quantity=? WHERE id=?");
        $stmt->bind_param("ssddii", $code, $name, $buying_price, $selling_price, $quantity, $id);
    }
    $stmt->execute();
    header("Location: manage-items.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM items WHERE id = $id");
    header("Location: manage-items.php");
    exit;
}

$edit_item = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM items WHERE id = $id");
    $edit_item = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Items</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function fetchItemName() {
        const code = document.querySelector('[name=item_code]').value;
        if (code.length > 0) {
            fetch('fetch-item.php?code=' + code)
                .then(res => res.json())
                .then(data => {
                    if (!data.error) {
                        document.querySelector('[name=name]').value = data.name;
                    }
                });
        }
    }
    </script>
</head>
<body>
    <h2>Manage Items</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php if ($edit_item): ?>
            <input type="hidden" name="id" value="<?php echo $edit_item['id']; ?>">
        <?php endif; ?>
        <label>Item Code:</label>
        <input type="text" name="item_code" value="<?php echo $edit_item['item_code'] ?? ''; ?>" required onblur="fetchItemName()"><br>
        <label>Item Name:</label>
        <input type="text" name="name" value="<?php echo $edit_item['name'] ?? ''; ?>" required><br>
        <label>Buying Price:</label>
        <input type="number" step="0.01" name="buying_price" value="<?php echo $edit_item['buying_price'] ?? ''; ?>" required><br>
        <label>Selling Price:</label>
        <input type="number" step="0.01" name="selling_price" value="<?php echo $edit_item['selling_price'] ?? ''; ?>" required><br>
        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $edit_item['quantity'] ?? 0; ?>" required><br>
        <label>Upload up to 5 Images:</label><br>
        <?php for ($i = 0; $i < 5; $i++): ?>
            <input type="file" name="images[]"><br>
        <?php endfor; ?>
        <button type="submit" name="<?php echo $edit_item ? 'update_item' : 'add_item'; ?>">
            <?php echo $edit_item ? 'Update Item' : 'Add Item'; ?>
        </button>
    </form>

    <h3>Item List</h3>
    <table border="1">
        <tr><th>Item Code</th><th>Name</th><th>Buying Price</th><th>Selling Price</th><th>Quantity</th><th>Action</th></tr>
        <?php
        $result = $conn->query("SELECT * FROM items ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['item_code']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['buying_price']}</td>
                    <td>{$row['selling_price']}</td>
                    <td>{$row['quantity']}</td>
                    <td>
                        <a href='manage-items.php?edit={$row['id']}'>Edit</a> |
                        <a href='manage-items.php?delete={$row['id']}' onclick=\"return confirm('Are you sure?');\">Delete</a> | ";
            if ($row['image']) {
                $images = explode(",", $row['image']);
                foreach ($images as $img) {
                    echo "<a href='{$img}' target='_blank'>View Image</a> ";
                }
            } else {
                echo "No Image";
            }
            echo "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
