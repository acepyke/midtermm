<?php include "db.php"; ?>

<?php
// CREATE PRODUCT
if (isset($_POST['create_product'])) {
    $name = $_POST['name'];
    $sku = $_POST['sku'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if ($price <= 0 || $stock < 0) {
        echo "Invalid values!";
    } else {
        $check = $conn->query("SELECT * FROM products WHERE sku='$sku'");
        if ($check->num_rows > 0) {
            echo "SKU must be unique!";
        } else {
            $conn->query("INSERT INTO products (name, sku, price, stock)
            VALUES ('$name','$sku','$price','$stock')");
            echo "Product Created!";
        }
    }
}

// DELETE PRODUCT
if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];
    $conn->query("DELETE FROM products WHERE id=$id");
}

// UPDATE PRODUCT
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if ($price < 0 || $stock < 0) {
        echo "No negative values!";
    } else {
        $conn->query("UPDATE products SET price='$price', stock='$stock' WHERE id=$id");
        echo "Updated!";
    }
}

// GET PRODUCTS
$products = $conn->query("SELECT * FROM products");
?>

<h2>Product System</h2>

<form method="POST">
    Name: <input name="name"><br>
    SKU: <input name="sku"><br>
    Price: <input name="price"><br>
    Stock: <input name="stock"><br>
    <button name="create_product">Add Product</button>
</form>

<hr>

<table border="1">
<tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Action</th></tr>

<?php while($p = $products->fetch_assoc()) { ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['name'] ?></td>
    <td><?= $p['price'] ?></td>
    <td><?= $p['stock'] ?></td>
    <td>
        <a href="?delete_product=<?= $p['id'] ?>">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

<hr>

<h3>Update Product</h3>
<form method="POST">
    ID: <input name="id"><br>
    Price: <input name="price"><br>
    Stock: <input name="stock"><br>
    <button name="update_product">Update</button>
</form>