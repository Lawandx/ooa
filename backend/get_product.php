<?php
include_once 'functions.php';

$product = new Product($conn);

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $productData = $product->getProductById($productId);

    if ($productData->num_rows > 0) {
        $row = $productData->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(["message" => "No product found"]);
    }
}
?>
