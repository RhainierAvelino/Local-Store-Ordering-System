<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit();
}

// Check if update parameter exists
if (!isset($_GET['update'])) {
    header('location:products.php');
    exit();
}

$update_id = $_GET['update'];

// Fetch the product details
$select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
$select_product->execute([$update_id]);
if ($select_product->rowCount() == 0) {
    header('location:products.php');
    exit();
}

$fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);

    // Update product details
    $update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, price = ? WHERE id = ?");
    $update_product->execute([$name, $category, $price, $update_id]);

    // Handle image update
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_img/' . $image;

        // Delete old image
        unlink('../uploaded_img/' . $fetch_product['image']);

        // Move new image
        move_uploaded_file($image_tmp_name, $image_folder);

        // Update image in the database
        $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
        $update_image->execute([$image, $update_id]);
    }

    $message[] = 'Product updated successfully!';
    header('location:products.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">

    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Update Product</h3>
        <input type="text" name="name" value="<?= htmlspecialchars($fetch_product['name']); ?>" class="box" required>
        <input type="number" min="0" max="9999999999" name="price" value="<?= htmlspecialchars($fetch_product['price']); ?>" class="box" required>
        <select name="category" class="box" required>
            <option value="Hotdogs" <?= $fetch_product['category'] == 'Hotdogs' ? 'selected' : ''; ?>>Hotdogs</option>
            <option value="Appetizers & Sides" <?= $fetch_product['category'] == 'Appetizers & Sides' ? 'selected' : ''; ?>>Appetizers & Sides</option>
            <option value="Refreshers & Coolers" <?= $fetch_product['category'] == 'Refreshers & Coolers' ? 'selected' : ''; ?>>Refreshers & Coolers</option>
            <option value="Coffee & Matcha" <?= $fetch_product['category'] == 'Coffee & Matcha' ? 'selected' : ''; ?>>Coffee & Matcha</option>
        </select>
        <img src="../uploaded_img/<?= $fetch_product['image']; ?>" width="100">
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
        <input type="submit" value="Update Product" name="update_product" class="btn">
    </form>

</section>

<!-- Custom JS -->
<script src="../js/admin_script.js"></script>

</body>
</html>
