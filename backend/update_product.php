<?php
include_once 'functions.php';

// เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['productIDUpdate']; 
    $productName = $_POST['productNameUpdate'];
    $productType = $_POST['productTypeUpdate'];
    $productBarcode = $_POST['productBarcodeUpdate'];
    $productPrice = $_POST['productPriceUpdate'];
    $productQuantity = $_POST['productQuantityUpdate'];
    $productStatus = $_POST['productStatusUpdate'];

    if (isset($_FILES['productImageUpdate']) && $_FILES['productImageUpdate']['error'] === 0) {
        $file_name = $_FILES['productImageUpdate']['name'];
        $file_tmp = $_FILES['productImageUpdate']['tmp_name'];
        $file_size = $_FILES['productImageUpdate']['size'];
        
        $file_ext = pathinfo($_FILES['productImageUpdate']['name'], PATHINFO_EXTENSION);
        $allowed = array('jpg', 'jpeg', 'png'); 

        if (in_array($file_ext, $allowed)) {
            if ($file_size < 5242880) { 
                $file_destination = 'uploads/' . $file_name; 
                move_uploaded_file($file_tmp, $file_destination);

                $product = new Product($conn);
                $result = $product->updateProduct($conn, $productId, $productName, $productType, $productBarcode, $productPrice, $productQuantity, $productStatus, $file_destination);

                if ($result) {
                    echo '<script>alert("The update was successful.!"); window.location.href = "products.php";</script>';
                    exit();
                } else {
                    echo '<script>alert("There was an error updating information.!"); window.location.href = "products.php";</script>';
                }
            } else {
                echo '<script>alert("The file size is too large.!"); window.location.href = "products.php";</script>';
            }
        } else {
            echo '<script>alert("This file cannot be uploaded.!"); window.location.href = "products.php";</script>';
        }
    } else {
        $product = new Product($conn);
        $result = $product->updateProductWithoutImage($conn, $productId, $productName, $productType, $productBarcode, $productPrice, $productQuantity, $productStatus);

        if ($result) {
            echo '<script>alert("The update was successful.!"); window.location.href = "products.php";</script>';
            exit();
        } else {
            echo '<script>alert("There was an error updating information.!"); window.location.href = "products.php";</script>';
        }
    }
}
?>
