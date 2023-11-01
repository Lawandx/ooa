<?php
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    $product = new Product($conn);
    $product->deleteProduct($productId);
}
?>